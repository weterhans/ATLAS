<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) // Hapus ': RedirectResponse' jika ada
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:50'],
            'password' => ['required', 'confirmed'], // 'confirmed' otomatis cek 'password_confirmation'
            'signature_base64' => ['required', 'string'], // Validasi data tanda tangan
        ]);

        // 2. Proses Tanda Tangan
        $signaturePath = null; // Default null
        if ($request->filled('signature_base64')) {
            try {
                // Ambil data base64 dari input
                $signatureData = $request->signature_base64;

                // Pisahin 'data:image/png;base64,' dari datanya
                @list($type, $data) = explode(';', $signatureData);
                @list(, $data) = explode(',', $data);

                // Decode data base64 jadi gambar
                $decodedData = base64_decode($data);

                // Bikin nama file yang unik
                $filename = 'signatures/' . $request->username . '-' . Str::uuid() . '.png';

                // Simpen file-nya ke 'storage/app/public/signatures'
                Storage::disk('public')->put($filename, $decodedData);

                // Simpen path-nya buat dimasukin ke database
                $signaturePath = $filename;
            } catch (\Exception $e) {
                // Kalo gagal, biarin aja (atau kasih error)
                // Di sini kita biarin $signaturePath tetep null
            }
        }

        // 3. Buat User baru di database
        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), // Enkripsi password
            'signature_url' => $signaturePath, // Masukin path tanda tangan
        ]);

        // 4. Kasih event (bawaan Breeze)
        event(new Registered($user));

        // 5. Langsung login-in user-nya
        // Auth::login($user);

        // 6. Lempar ke halaman dashboard
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
