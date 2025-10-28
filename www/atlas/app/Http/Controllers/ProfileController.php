<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Ambil semua data yg udah lolos validasi (termasuk avatar kalo ada)
        $validatedData = $request->validated();

        // Isi data user (kecuali avatar, kita urus manual)
        $user->fill([
            'fullname' => $validatedData['fullname'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'] ?? null, // Handle jika nullable
        ]);

        // PERUBAHAN: Urus File Avatar
        if ($request->hasFile('avatar')) {
            // 0. Hapus avatar lama jika ada
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            // 1. Simpan file baru ke 'storage/app/public/avatars'
            //    'avatars' -> nama folder (otomatis dibuat kalo belum ada)
            //    'public' -> visibility
            $path = $request->file('avatar')->store('avatars', 'public');

            // 2. Update kolom avatar_url user dengan path baru
            $user->avatar_url = $path;
        }

        // Kalo user-nya ganti email, reset status verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Simpen semua perubahan ke database
        $user->save();

        // Balik lagi ke halaman edit sambil bawa pesan sukses
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
