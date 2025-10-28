@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Dashboard">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 ml-4">Profil Pengguna</h1>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('status') === 'profile-updated')
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm shadow" role="alert">
        Profil berhasil diperbarui.
    </div>
    @endif

    {{-- Kartu Profil Utama --}}
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">

        {{-- Form untuk Update Profil --}}
        {{-- Kita ambil 'patch' (method) dan 'route' dari Breeze --}}
        <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="p-6 md:p-8">
                {{-- Bagian Header Kartu (Avatar, Nama, Edit Button) --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        {{-- Avatar Inisial --}}
                        @if (Auth::user()->avatar_url)
                        {{-- Tampilkan avatar jika ada --}}
                        <img src="{{ Storage::url(Auth::user()->avatar_url) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                        @else
                        {{-- Tampilkan inisial jika tidak ada avatar --}}
                        <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-3xl font-semibold text-indigo-600">
                                {{ strtoupper(substr(Auth::user()->fullname, 0, 1)) }}
                            </span>
                        </div>
                        @endif

                        <div>
                            {{-- Nama Lengkap (dari data user yg login) --}}
                            <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->fullname }}</h2>
                            {{-- Username (dari data user yg login) --}}
                            <p class="text-sm text-gray-500">@ {{ Auth::user()->username }}</p>
                        </div>
                    </div>
                    {{-- Tombol 'Edit' kita ganti jadi 'Simpan' karena ini halaman edit --}}
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan
                    </button>
                </div>

                <hr class="my-6">

                {{-- Bagian Detail Form --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">

                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700">Ganti Foto Profil</label>
                        <input type="file" id="avatar" name="avatar"
                            class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100
                                 " />
                        {{-- Tampilkan error validasi avatar --}}
                        @error('avatar') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Nama Lengkap --}}
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <input type="text" id="fullname" name="fullname"
                            value="{{ old('fullname', $user->fullname) }}"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg p-3 font-semibold text-gray-800">
                        @error('fullname') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-500">Username</label>
                        <input type="text" id="username" name="username"
                            value="{{ old('username', $user->username) }}"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg p-3 font-semibold text-gray-800">
                        @error('username') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-500">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg p-3 font-semibold text-gray-800">
                        @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Nomor WhatsApp --}}
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-500">Nomor WhatsApp</label>
                        <input type="text" id="phone_number" name="phone_number"
                            value="{{ old('phone_number', $user->phone_number) }}"
                            placeholder="-"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg p-3 font-semibold text-gray-800">
                        @error('phone_number') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Info ID Pengguna (Tidak bisa diedit) --}}
                    <div>
                        <span class="block text-sm font-medium text-gray-500">ID Pengguna</span>
                        <p class="mt-1 sm:text-lg p-3 font-semibold text-gray-800">{{ $user->id }}</p>
                    </div>

                    {{-- Info Lokasi/Role (Tidak bisa diedit) --}}
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Jabatan</span>
                        <p class="mt-1 sm:text-lg p-3 font-semibold text-gray-800">{{ $user->role }}</Data></p>
                    </div>

                </div>
            </div>
        </form>

    </div>

    {{-- Kartu Ganti Password (Kita ambil dari Breeze) --}}
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8">
        <div class="p-6 md:p-8">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>
@endsection