@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('cnsd.jadwal') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Daftar Jadwal">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Edit Jadwal Dinas CNSD</h1>
        </div>
    </div>

    {{-- Form Edit Jadwal --}}
    <div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-lg">
        {{-- Arahkan ke route update, pakai method PUT --}}
        <form action="{{ route('cnsd.jadwal.update', $schedule) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT') {{-- PENTING untuk update --}}

            {{-- ID Jadwal (Readonly) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">ID Jadwal</label>
                <input type="text" value="{{ $schedule->schedule_id_custom }}" readonly
                       class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                {{-- old('tanggal', $schedule->tanggal->format('Y-m-d')) -> ambil data lama jika validasi gagal, jika tidak, ambil dari DB --}}
                <input type="date" id="tanggal" name="tanggal" required
                       value="{{ old('tanggal', $schedule->tanggal->format('Y-m-d')) }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error('tanggal') border-red-500 @enderror">
                @error('tanggal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Dinas --}}
            <div>
                <label for="dinas" class="block text-sm font-medium text-gray-700">Dinas</label>
                <select id="dinas" name="dinas" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error('dinas') border-red-500 @enderror">
                    <option value="">Pilih Dinas</option>
                    {{-- selected -> pilih opsi yg sesuai data lama/dari DB --}}
                    <option value="Pagi" {{ old('dinas', $schedule->dinas) == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                    <option value="Siang" {{ old('dinas', $schedule->dinas) == 'Siang' ? 'selected' : '' }}>Siang</option>
                    <option value="Malam" {{ old('dinas', $schedule->dinas) == 'Malam' ? 'selected' : '' }}>Malam</option>
                </select>
                 @error('dinas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Teknisi 1-6 --}}
            @for ($i = 1; $i <= 6; $i++)
            @php $fieldName = 'teknisi_' . $i; @endphp
            <div>
                <label for="{{ $fieldName }}" class="block text-sm font-medium text-gray-700">
                    Pilih Teknisi {{ $i }} {{ $i > 3 ? '(Opsional)' : '' }}
                </label>
                <select id="{{ $fieldName }}" name="{{ $fieldName }}"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error($fieldName) border-red-500 @enderror"
                        {{ $i <= 3 ? 'required' : '' }}>
                    <option value="">-- Pilih Teknisi --</option>
                    @foreach ($teknisiList as $namaTeknisi)
                        <option value="{{ $namaTeknisi }}" {{ old($fieldName, $schedule->$fieldName) == $namaTeknisi ? 'selected' : '' }}>
                            {{ $namaTeknisi }}
                        </option>
                    @endforeach
                </select>
                 @error($fieldName) <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            @endfor

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center border-t pt-4 mt-6 space-x-2">
                <a href="{{ route('cnsd.jadwal') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Kembali
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection