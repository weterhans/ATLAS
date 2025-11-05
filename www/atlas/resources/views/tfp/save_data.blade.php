@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            {{-- Ganti route ke tfp.index (menu TFP) --}}
            <a href="{{ route('tfp.index') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            {{-- Ganti Judul --}}
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Save Data TFP</h1>
        </div>
    </div>

    {{-- Notifikasi Sukses/Error (Sama) --}}
    @if (session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700" role="alert">
        @if (session('error'))
        <p class="font-bold mb-2">{{ session('error') }}</p>
        @else
        <p class="font-bold mb-2">Gagal menyimpan data:</p>
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>
    @endif

    {{-- Daftar Data Tersimpan (Sama, datanya dari controller TFP) --}}
    <div class="space-y-6">
        @forelse ($groupedData as $date => $items)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Header Tanggal --}}
            <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-600 uppercase">
                    {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM YYYY') }}
                </h2>
            </div>

            {{-- List Item per Tanggal --}}
            <ul class="divide-y divide-gray-200">
                @foreach ($items as $item)
                <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 cursor-pointer"
                    x-data="{ reportType: '{{ $item->type }}' }"
                    x-on:click="$dispatch('open-summary-modal', {
                        report: {
                            id: '{{ $item->id }}', type: reportType,
                            tanggal: '{{ $item->tanggal->format('Y-m-d') }}',
                            tanggal_formatted: '{{ $item->tanggal->isoFormat('dddd, D MMMM YYYY') }}',
                            dinas: '{{ $item->dinas ?? '' }}', mantek: '{{ $item->mantek ?? '' }}',
                            print: '{{ $item->print }}', grup: '{{ $item->grup }}',
                            nama_alat: '{{ $item->nama_alat ?? '' }}',
                            sampai: '{{ $item->sampai ? $item->sampai->format('d/m/Y') : '' }}',
                            sampai_db: '{{ $item->sampai ? $item->sampai->format('Y-m-d') : '' }}',
                            file_path: '{{ $item->file_path ?? '' }}'
                        }
                    })">

                    {{-- Info Utama (Kiri) --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            @if($item->file_name) {{ $item->file_name }}
                            @else {{ $item->type }} - {{ $item->dinas ?? $item->nama_alat ?? 'Data' }}
                            @if($item->mantek) (Oleh: {{ $item->mantek }}) @endif
                            @endif
                        </p>
                        <p class="text-sm text-gray-500">
                            Tipe: {{ $item->type }}
                            @if($item->dinas) | Dinas: {{ $item->dinas }} @endif
                            @if($item->sampai) | Sampai: {{ $item->sampai->format('d M Y') }} @endif
                        </p>
                    </div>

                    {{-- Tombol Aksi di Kanan (Logika Alpine-nya sama) --}}
                    <div class="ml-4 flex-shrink-0 flex items-center space-x-2">
                        <span class="text-sm text-gray-500 hidden sm:inline">
                            {{ $item->mantek ?? ($item->nama_alat === 'ALL Equipment' ? 'Semua Alat' : ($item->print === 'YA' ? 'Teknisi B' : '-')) }}
                        </span>

                        <button title="Jadwal" class="p-1 text-gray-400 hover:text-blue-600"
                            x-on:click.stop="
                                if (reportType === 'Harian') {
                                    $dispatch('open-jadwal-modal', {
                                        report: { id: '{{ $item->id }}', type_laporan: reportType, tanggal_formatted: '{{ $item->tanggal->isoFormat('dddd, D MMMM YYYY') }}', dinas: '{{ $item->dinas ?? '' }}', tanggal_db: '{{ $item->tanggal->format('Y-m-d') }}' }
                                    });
                                } else { // Bulanan
                                    $dispatch('open-jadwal-bulanan-modal', {
                                        report: { id: '{{ $item->id }}', type_laporan: reportType, tanggal_mulai: '{{ $item->tanggal->format('Y-m-d') }}', tanggal_selesai: '{{ $item->sampai ? $item->sampai->format('Y-m-d') : '' }}', nama_alat: '{{ $item->nama_alat ?? '' }}' }
                                    });
                                }
                            ">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </button>

                        <button title="Kegiatan" class="p-1 text-gray-400 hover:text-gray-600"
                            x-on:click.stop="
                                if (reportType === 'Harian') {
                                    $dispatch('open-kegiatan-modal', {
                                        report: { id: '{{ $item->id }}', dinas: '{{ $item->dinas ?? '' }}', tanggal_db: '{{ $item->tanggal->format('Y-m-d') }}' }
                                    });
                                } else { // Bulanan (buka modal summary)
                                    $dispatch('open-summary-modal', {
                                        report: { id: '{{ $item->id }}', type: reportType, tanggal: '{{ $item->tanggal->format('Y-m-d') }}', tanggal_formatted: '{{ $item->tanggal->isoFormat('dddd, D MMMM YYYY') }}', nama_alat: '{{ $item->nama_alat ?? '' }}', sampai: '{{ $item->sampai ? $item->sampai->format('d/m/Y') : '' }}', sampai_db: '{{ $item->sampai ? $item->sampai->format('Y-m-d') : '' }}' }
                                    });
                                }
                            ">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </button>

                        <button title="Edit" class="p-1 text-gray-400 hover:text-indigo-600"
                            x-on:click.stop="$dispatch('open-edit-modal', {
                                report: { id: '{{ $item->id }}', type: reportType, tanggal: '{{ $item->tanggal->format('Y-m-d') }}', dinas: '{{ $item->dinas ?? '' }}', mantek: '{{ $item->mantek ?? '' }}', print: '{{ $item->print }}', grup: '{{ $item->grup }}', nama_alat: '{{ $item->nama_alat ?? '' }}', sampai: '{{ $item->sampai ? $item->sampai->format('Y-m-d') : '' }}' }
                            })">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>

                        <button title="Delete" class="p-1 text-gray-400 hover:text-red-600"
                            x-on:click.stop="$dispatch('open-delete-modal', {
                                id: '{{ $item->id }}', name: '{{ $item->file_name ?? ($item->type . ' - ' . ($item->dinas ?? $item->nama_alat)) }}'
                            })">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @empty
        <div class="text-center py-10 text-gray-500">
            Belum ada data yang tersimpan.
        </div>
        @endforelse
    </div>

    {{-- Tombol Tambah (+) Floating (Sama) --}}
    <button id="add-savedata-btn" title="Tambah Data Baru"
        class="fixed bottom-8 right-8 p-4 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
    </button>
</div>

{{-- ========================================================================= --}}
{{-- MODAL AREA --}}
{{-- ========================================================================= --}}

{{-- >>> AWAL MODAL TAMBAH SAVE DATA TFP <<< --}}
<div id="add-savedata-modal" x-data="{ showModal: false, optionType: 'Harian' }" x-show="showModal" x-on:open-modal.window="showModal = true; optionType = 'Harian'; setTimeout(() => { document.getElementById('add-savedata-form').reset(); document.getElementById('save_tanggal').value = '{{ date('Y-m-d') }}'; document.querySelector('input[name=print][value=YA]').checked = true; }, 50);" x-on:keydown.escape.window="showModal = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 px-4" style="display: none;" aria-labelledby="modal-title-tfp-savedata" role="dialog" aria-modal="true">
    <div class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white" @click.outside="showModal = false">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-savedata" class="text-xl font-semibold text-gray-900">Tambah Data</h3> {{-- Ganti ID --}}
            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        {{-- Ganti action route ke tfp.save_data.store --}}
        <form id="add-savedata-form" action="{{ route('tfp.save_data.store') }}" method="POST" class="space-y-4">
            @csrf
            {{-- Ganti value grup ke TFP --}}
            <input type="hidden" name="grup" value="TFP">
            <input type="hidden" name="type" x-bind:value="optionType">
            <div> <label class="block text-base font-medium text-gray-700 mb-1">OPSI</label>
                <div class="flex rounded-lg border border-gray-300 overflow-hidden"> <button type="button" @click="optionType = 'Harian'" :class="{ 'bg-indigo-600 text-white': optionType === 'Harian', 'bg-gray-100 text-gray-600 hover:bg-gray-200': optionType !== 'Harian' }" class="flex-1 text-center p-2 rounded-l-md transition-colors text-base font-medium">HARIAN</button> <button type="button" @click="optionType = 'Bulanan'" :class="{ 'bg-indigo-600 text-white': optionType === 'Bulanan', 'bg-gray-100 text-gray-600 hover:bg-gray-200': optionType !== 'Bulanan' }" class="flex-1 text-center p-2 border-l border-gray-300 rounded-r-md transition-colors text-base font-medium">BULANAN</button> </div>
            </div>
            <div> <label for="save_tanggal" class="block text-base font-medium text-gray-700">TANGGAL *</label> <input type="date" id="save_tanggal" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base @error('tanggal') border-red-500 @enderror"> @error('tanggal') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror </div>
            <div x-show="optionType === 'Harian'" x-transition class="space-y-4">
                <div> <label class="block text-base font-medium text-gray-700 mb-1">DINAS</label>
                    <div class="flex rounded-lg border border-gray-300 overflow-hidden"> <button type="button" data-dinas="PAGI" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#add-savedata-form input[name=dinas][value=PAGI]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#add-savedata-form input[name=dinas][value=PAGI]').checked }" class="flex-1 dinas-btn text-center p-2 rounded-l-md transition-colors text-gray-600 text-base font-medium">PAGI</button> <button type="button" data-dinas="SIANG" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#add-savedata-form input[name=dinas][value=SIANG]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#add-savedata-form input[name=dinas][value=SIANG]').checked }" class="flex-1 dinas-btn text-center p-2 border-l border-r border-gray-300 transition-colors text-gray-600 text-base font-medium">SIANG</button> <button type="button" data-dinas="MALAM" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#add-savedata-form input[name=dinas][value=MALAM]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#add-savedata-form input[name=dinas][value=MALAM]').checked }" class="flex-1 dinas-btn text-center p-2 rounded-r-md transition-colors text-gray-600 text-base font-medium">MALAM</button> <input type="radio" name="dinas" value="PAGI" class="sr-only"><input type="radio" name="dinas" value="SIANG" class="sr-only"><input type="radio" name="dinas" value="MALAM" class="sr-only"> </div> @error('dinas') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div> <label for="save_mantek" class="block text-base font-medium text-gray-700">MANTEK *</label> <select id="save_mantek" name="mantek" x-bind:required="optionType === 'Harian'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base @error('mantek') border-red-500 @enderror">
                        <option value="">Pilih Mantek</option> @foreach ($userList as $name => $val) <option value="{{ $name }}" {{ old('mantek') == $name ? 'selected' : '' }}>{{ $name }}</option> @endforeach
                    </select> @error('mantek') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror </div>
            </div>
            <div x-show="optionType === 'Bulanan'" x-transition class="space-y-4">
                <div> <label for="save_nama_alat" class="block text-base font-medium text-gray-700">NAMA ALAT *</label> <select id="save_nama_alat" name="nama_alat" x-bind:required="optionType === 'Bulanan'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base @error('nama_alat') border-red-500 @enderror">
                        <option value="">Pilih Alat...</option>
                        <option value="ALL Equipment" {{ old('nama_alat') == 'ALL Equipment' ? 'selected' : '' }}>ALL Equipment</option> @foreach ($equipmentList as $name => $val) <option value="{{ $name }}" {{ old('nama_alat') == $name ? 'selected' : '' }}>{{ $name }}</option> @endforeach
                    </select> @error('nama_alat') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror </div>
                <div> <label for="save_sampai" class="block text-base font-medium text-gray-700">SAMPAI *</label> <input type="date" id="save_sampai" name="sampai" x-bind:required="optionType === 'Bulanan'" value="{{ old('sampai') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base @error('sampai') border-red-500 @enderror"> @error('sampai') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror </div>
            </div>
            <div> <label class="block text-base font-medium text-gray-700 mb-1">PRINT</label>
                <div class="flex rounded-lg border border-gray-300 overflow-hidden"> <button type="button" data-print="YA" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#add-savedata-form input[name=print][value=YA]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#add-savedata-form input[name=print][value=YA]').checked }" class="flex-1 print-btn text-center p-2 rounded-l-md transition-colors text-gray-600 text-base font-medium">YA</button> <button type="button" data-print="TIDAK" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#add-savedata-form input[name=print][value=TIDAK]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#add-savedata-form input[name=print][value=TIDAK]').checked }" class="flex-1 print-btn text-center p-2 border-l border-gray-300 rounded-r-md transition-colors text-gray-600 text-base font-medium">TIDAK</button> <input type="radio" name="print" value="YA" class="sr-only" checked> <input type="radio" name="print" value="TIDAK" class="sr-only"> </div> @error('print') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            {{-- Ganti value grup ke TFP --}}
            <div> <label class="block text-base font-medium text-gray-700">GROUP</label> <input type="text" value="TFP" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed text-base"> </div>
            <div class="flex justify-end items-center border-t pt-4 mt-6 space-x-2"> <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-base font-medium">Batal</button> <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-base font-medium">Simpan</button> </div>
        </form>
    </div>
</div>

{{-- >>> AWAL MODAL DETAIL JADWAL (HARIAN) <<< --}}
<div id="detail-jadwal-modal" x-data="{ showModal: false, report: { type_laporan: '', tanggal_formatted: '', dinas: '', tanggal_db: '' }, schedule: null, loadingSchedule: false, scheduleError: '' }" x-show="showModal" x-on:open-jadwal-modal.window=" showModal = true; report = $event.detail.report; schedule = null; scheduleError = ''; if (report.dinas && report.tanggal_db) { loadingSchedule = true; if(typeof window.fetchScheduleDetails === 'function') { window.fetchScheduleDetails($data, report.tanggal_db, report.dinas); } else { console.error('Fungsi fetchScheduleDetails tidak ditemukan.'); scheduleError = 'Error: Fungsi internal tidak siap.'; loadingSchedule = false; } } else { scheduleError = 'Data laporan tidak lengkap untuk mencari jadwal.'; loadingSchedule = false; } " x-on:keydown.escape.window="showModal = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 px-4" style="display: none;" aria-labelledby="modal-title-tfp-jadwal" role="dialog" aria-modal="true">
    <div class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white" @click.outside="showModal = false">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-jadwal" class="text-xl font-semibold text-gray-900">Detail Jadwal</h3> {{-- Ganti ID --}}
            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="space-y-4 text-base max-h-[70vh] overflow-y-auto pr-2">
            <div class="grid grid-cols-3 gap-x-4 gap-y-1">
                <div class="col-span-1 text-gray-500 font-medium">Tipe Laporan:</div>
                <div class="col-span-2 text-gray-800" x-text="report.type_laporan === 'Harian' ? 'Laporan Harian' : (report.type_laporan || '-')"></div>
                <div class="col-span-1 text-gray-500 font-medium">Tanggal:</div>
                <div class="col-span-2 text-gray-800" x-text="report.tanggal_formatted || '-'"></div>
            </div>
            <hr>
            <div>
                <h4 class="text-base font-semibold text-gray-700 mb-2">Jadwal Dinas Tanggal Ini:</h4>
                <div x-show="loadingSchedule" class="text-gray-500 italic">Memuat detail jadwal...</div>
                <div x-show="!loadingSchedule && scheduleError" class="text-red-500" x-text="scheduleError"></div>
                <div x-show="!loadingSchedule && schedule" class="bg-gray-50 p-4 rounded-lg space-y-1">
                    <div class="grid grid-cols-3 gap-x-4">
                        <div class="col-span-1 text-gray-600 font-medium">ID Jadwal:</div>
                        <div class="col-span-2 text-gray-900" x-text="schedule?.id_jadwal || '-'"></div>
                        <div class="col-span-1 text-gray-600 font-medium">Dinas:</div>
                        <div class="col-span-2 text-gray-900" x-text="schedule?.dinas || '-'"></div>
                        <div class="col-span-1 text-gray-600 font-medium">Teknisi 1:</div>
                        <div class="col-span-2 text-gray-900" x-text="schedule?.teknisi1 || '-'"></div>
                        <div class="col-span-1 text-gray-600 font-medium">Teknisi 2:</div>
                        <div class="col-span-2 text-gray-900" x-text="schedule?.teknisi2 || '-'"></div>
                        <div class="col-span-1 text-gray-600 font-medium">Teknisi 3:</div>
                        <div class="col-span-2 text-gray-900" x-text="schedule?.teknisi3 || '-'"></div>
                        <div class="col-span-1 text-gray-600 font-medium">Kode:</div>
                        <div class="col-span-2 text-gray-900" x-text="schedule?.kode || '-'"></div>
                        <div class="col-span-1 text-gray-600 font-medium">Grup:</div>
                        <div class="col-span-2 text-gray-900" x-text="schedule?.grup || '-'"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- >>> AWAL MODAL DETAIL KEGIATAN (HARIAN) <<< --}}
<div id="detail-kegiatan-modal" x-data="{ showModal: false, report: { dinas: '', tanggal_db: '' }, activity: null, loadingActivity: false, activityError: '' }" x-show="showModal" x-on:open-kegiatan-modal.window=" showModal = true; report = $event.detail.report; activity = null; activityError = ''; if (report.dinas && report.tanggal_db) { loadingActivity = true; if(typeof window.fetchActivityDetails === 'function') { window.fetchActivityDetails($data, report.tanggal_db, report.dinas); } else { console.error('Fungsi fetchActivityDetails tidak ditemukan.'); activityError = 'Error: Fungsi internal tidak siap.'; loadingActivity = false; } } else { activityError = 'Data laporan tidak lengkap untuk mencari kegiatan.'; loadingActivity = false; } " x-on:keydown.escape.window="showModal = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 px-4" style="display: none;" aria-labelledby="modal-title-tfp-kegiatan" role="dialog" aria-modal="true">
    <div class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white" @click.outside="showModal = false">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-kegiatan" class="text-xl font-semibold text-gray-900">Detail Kegiatan</h3> {{-- Ganti ID --}}
            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="space-y-4 text-base max-h-[70vh] overflow-y-auto pr-2">
            <div x-show="loadingActivity" class="text-gray-500 italic">Memuat detail kegiatan...</div>
            <div x-show="!loadingActivity && activityError" class="text-red-500" x-text="activityError"></div>
            <div x-show="!loadingActivity && activity" class="grid grid-cols-3 gap-x-4 gap-y-1">
                <div class="col-span-1 text-gray-500 font-medium">Kode:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.kode || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Dinas:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.dinas || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Waktu Mulai:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.waktu_mulai || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Waktu Selesai:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.waktu_selesai || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Alat:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.alat || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Permasalahan:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.permasalahan || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Tindakan:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.tindakan || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Hasil:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.hasil || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Status:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.status || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Teknisi:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.teknisi_formatted || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Waktu Putus:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.waktu_putus || '-'"></div>
                <div class="col-span-1 text-gray-500 font-medium">Lampiran:</div>
                <div class="col-span-2 text-gray-800" x-text="activity?.lampiran_count > 0 ? activity?.lampiran_count + ' file' : '-'"></div>
            </div>
        </div>
    </div>
</div>

{{-- >>> AWAL MODAL EDIT SAVE DATA TFP <<< --}}
<div id="edit-savedata-modal" x-data="{ showModal: false, optionType: 'Harian', reportId: null }" x-show="showModal"
    {{-- Ganti URL action di Alpine --}}
    x-on:open-edit-modal.window="
        showModal = true;
        const report = $event.detail.report;
        reportId = report.id;
        optionType = report.type;
        const form = document.getElementById('edit-savedata-form');
        form.action = `{{ url('tfp/save-data') }}/${report.id}`;
        form.querySelector('[name=type]').value = report.type;
        form.querySelector('[name=tanggal]').value = report.tanggal;
        form.querySelector(`input[name=print][value='${report.print}']`).checked = true;
        if(report.type === 'Harian') {
            if(report.dinas) form.querySelector(`input[name=dinas][value='${report.dinas}']`).checked = true;
            form.querySelector('[name=mantek]').value = report.mantek;
        }
        if(report.type === 'Bulanan') {
            form.querySelector('[name=nama_alat]').value = report.nama_alat;
            form.querySelector('[name=sampai]').value = report.sampai;
        }
        window.updateRadioButtonsUI(form);
    "
    x-on:keydown.escape.window="showModal = false"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 px-4"
    style="display: none;" aria-labelledby="modal-title-tfp-edit" role="dialog" aria-modal="true">

    <div class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white" @click.outside="showModal = false">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-edit" class="text-xl font-semibold text-gray-900">Edit Data</h3> {{-- Ganti ID --}}
            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <form id="edit-savedata-form" action="" method="POST" class="space-y-4">
            @csrf @method('PUT')
            {{-- Ganti value grup ke TFP --}}
            <input type="hidden" name="grup" value="TFP">
            <input type="hidden" name="type" x-bind:value="optionType">
            <div> <label class="block text-base font-medium text-gray-700 mb-1">OPSI</label>
                <div class="flex rounded-lg border border-gray-300 overflow-hidden"> <button type="button" @click="optionType = 'Harian'" :class="{ 'bg-indigo-600 text-white': optionType === 'Harian', 'bg-gray-100 text-gray-600 hover:bg-gray-200': optionType !== 'Harian' }" class="flex-1 text-center p-2 rounded-l-md transition-colors text-base font-medium">HARIAN</button> <button type="button" @click="optionType = 'Bulanan'" :class="{ 'bg-indigo-600 text-white': optionType === 'Bulanan', 'bg-gray-100 text-gray-600 hover:bg-gray-200': optionType !== 'Bulanan' }" class="flex-1 text-center p-2 border-l border-gray-300 rounded-r-md transition-colors text-base font-medium">BULANAN</button> </div>
            </div>
            <div> <label for="edit_tanggal" class="block text-base font-medium text-gray-700">TANGGAL *</label> <input type="date" id="edit_tanggal" name="tanggal" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base"> </div>
            <div x-show="optionType === 'Harian'" x-transition class="space-y-4">
                <div> <label class="block text-base font-medium text-gray-700 mb-1">DINAS</label>
                    <div class="flex rounded-lg border border-gray-300 overflow-hidden"> <button type="button" data-dinas="PAGI" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#edit-savedata-form input[name=dinas][value=PAGI]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#edit-savedata-form input[name=dinas][value=PAGI]').checked }" class="flex-1 dinas-btn text-center p-2 rounded-l-md transition-colors text-gray-600 text-base font-medium">PAGI</button> <button type="button" data-dinas="SIANG" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#edit-savedata-form input[name=dinas][value=SIANG]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#edit-savedata-form input[name=dinas][value=SIANG]').checked }" class="flex-1 dinas-btn text-center p-2 border-l border-r border-gray-300 transition-colors text-gray-600 text-base font-medium">SIANG</button> <button type="button" data-dinas="MALAM" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#edit-savedata-form input[name=dinas][value=MALAM]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#edit-savedata-form input[name=dinas][value=MALAM]').checked }" class="flex-1 dinas-btn text-center p-2 rounded-r-md transition-colors text-gray-600 text-base font-medium">MALAM</button> <input type="radio" name="dinas" value="PAGI" class="sr-only"><input type="radio" name="dinas" value="SIANG" class="sr-only"><input type="radio" name="dinas" value="MALAM" class="sr-only"> </div>
                </div>
                <div> <label for="edit_mantek" class="block text-base font-medium text-gray-700">MANTEK *</label> <select id="edit_mantek" name="mantek" x-bind:required="optionType === 'Harian'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base">
                        <option value="">Pilih Mantek</option> @foreach ($userList as $name => $val) <option value="{{ $name }}">{{ $name }}</option> @endforeach
                    </select> </div>
            </div>
            <div x-show="optionType === 'Bulanan'" x-transition class="space-y-4">
                <div> <label for="edit_nama_alat" class="block text-base font-medium text-gray-700">NAMA ALAT *</label> <select id="edit_nama_alat" name="nama_alat" x-bind:required="optionType === 'Bulanan'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base">
                        <option value="">Pilih Alat...</option>
                        <option value="ALL Equipment">ALL Equipment</option> @foreach ($equipmentList as $name => $val) <option value="{{ $name }}">{{ $name }}</option> @endforeach
                    </select> </div>
                <div> <label for="edit_sampai" class="block text-base font-medium text-gray-700">SAMPAI *</label> <input type="date" id="edit_sampai" name="sampai" x-bind:required="optionType === 'Bulanan'" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base"> </div>
            </div>
            <div> <label class="block text-base font-medium text-gray-700 mb-1">PRINT</label>
                <div class="flex rounded-lg border border-gray-300 overflow-hidden"> <button type="button" data-print="YA" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#edit-savedata-form input[name=print][value=YA]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#edit-savedata-form input[name=print][value=YA]').checked }" class="flex-1 print-btn text-center p-2 rounded-l-md transition-colors text-gray-600 text-base font-medium">YA</button> <button type="button" data-print="TIDAK" :class="{ 'bg-indigo-600 text-white': $root.querySelector('#edit-savedata-form input[name=print][value=TIDAK]').checked, 'bg-gray-100 hover:bg-gray-200': !$root.querySelector('#edit-savedata-form input[name=print][value=TIDAK]').checked }" class="flex-1 print-btn text-center p-2 border-l border-gray-300 rounded-r-md transition-colors text-gray-600 text-base font-medium">TIDAK</button> <input type="radio" name="print" value="YA" class="sr-only"> <input type="radio" name="print" value="TIDAK" class="sr-only"> </div>
            </div>
            {{-- Ganti value grup ke TFP --}}
            <div> <label class="block text-base font-medium text-gray-700">GROUP</label> <input type="text" value="TFP" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed text-base"> </div>
            <div class="flex justify-end items-center border-t pt-4 mt-6 space-x-2"> <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-base font-medium">Batal</button> <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-base font-medium">Simpan Perubahan</button> </div>
        </form>
    </div>
</div>

{{-- >>> AWAL MODAL KONFIRMASI DELETE <<< --}}
<div id="delete-savedata-modal" x-data="{ showModal: false, itemName: '', formAction: '' }" x-show="showModal"
    {{-- Ganti URL action di Alpine --}}
    x-on:open-delete-modal.window="
        showModal = true;
        itemName = $event.detail.name;
        formAction = `{{ url('tfp/save-data') }}/${$event.detail.id}`;
        document.getElementById('delete-savedata-form').action = formAction;
    "
    x-on:keydown.escape.window="showModal = false"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 px-4"
    style="display: none;" aria-labelledby="modal-title-tfp-delete" role="dialog" aria-modal="true">

    <div class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white" @click.outside="showModal = false">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-delete" class="text-xl font-semibold text-gray-900">Konfirmasi Hapus Data</h3> {{-- Ganti ID --}}
            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <form id="delete-savedata-form" action="" method="POST">
            @csrf @method('DELETE')
            <div class="py-2">
                <p class="text-base text-gray-700"> Anda yakin ingin menghapus data: <br> <strong x-text="itemName" class="font-medium"></strong>? </p>
                <p class="text-sm text-red-600 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="flex justify-end items-center border-t pt-4 mt-6 space-x-2"> <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-base font-medium"> Batal </button> <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 text-base font-medium"> Ya, Hapus </button> </div>
        </form>
    </div>
</div>

{{-- >>> AWAL MODAL DETAIL SUMMARY (LAPORAN HARIAN / KEGIATAN BULANAN) <<< --}}
<div id="detail-summary-modal" x-data="{ showModal: false, report: { type: '', tanggal: '', tanggal_formatted: '', dinas: '', mantek: '', print: '', grup: '', nama_alat: '', sampai: '', sampai_db: '', file_path: '' }, activity: null, groupedActivities: null, loadingActivity: false, activityError: '' }" x-show="showModal" x-on:open-summary-modal.window=" showModal = true; report = $event.detail.report; activity = null; groupedActivities = null; activityError = ''; loadingActivity = true; if (report.type === 'Harian' && report.tanggal && report.dinas) { if(typeof window.fetchSummaryActivityDetails === 'function') { window.fetchSummaryActivityDetails($data, report.tanggal, report.dinas); } else { console.error('Fungsi fetchSummaryActivityDetails tidak ditemukan.'); activityError = 'Error: Fungsi internal Harian tidak siap.'; loadingActivity = false; } } else if (report.type === 'Bulanan' && report.tanggal && report.sampai_db) { if(typeof window.fetchMonthlyActivityDetails === 'function') { window.fetchMonthlyActivityDetails($data, report.tanggal, report.sampai_db); } else { console.error('Fungsi fetchMonthlyActivityDetails tidak ditemukan.'); activityError = 'Error: Fungsi internal Bulanan tidak siap.'; loadingActivity = false; } } else { loadingActivity = false; } " x-on:keydown.escape.window="showModal = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 px-4" style="display: none;" aria-labelledby="modal-title-tfp-summary" role="dialog" aria-modal="true">
    <div class="relative mx-auto p-6 border w-full max-w-xl shadow-lg rounded-xl bg-white" @click.outside="showModal = false">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-summary" class="text-xl font-semibold text-gray-900" x-text="report.type === 'Harian' ? 'Detail Laporan' : 'Detail Kegiatan Bulanan'"></h3> {{-- Ganti ID --}}
            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="text-base max-h-[70vh] overflow-y-auto pr-2 space-y-4">

            {{-- Detail Laporan Utama --}}
            <div class="space-y-1">
                <div class="flex">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">Tipe:</span>
                    <span class="text-gray-800 font-semibold" x-text="report.type || '-'"></span>
                </div>
                <div class="flex">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">Tanggal:</span>
                    <span class="text-gray-800" x-text="report.tanggal_formatted || '-'"></span>
                </div>
                <template x-if="report.type === 'Harian'">
                    <>
                        <div class="flex">
                            <span class="w-32 text-gray-500 font-medium flex-shrink-0">Dinas:</span>
                            <span class="text-gray-800" x-text="report.dinas || '-'"></span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-500 font-medium flex-shrink-0">Mantek:</span>
                            <span class="text-gray-800" x-text="report.mantek || '-'"></span>
                        </div>
                    </>
                </template>
                <template x-if="report.type === 'Bulanan'">
                    <>
                        <div class="flex">
                            <span class="w-32 text-gray-500 font-medium flex-shrink-0">Nama Alat:</span>
                            <span class="text-gray-800" x-text="report.nama_alat || '-'"></span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-500 font-medium flex-shrink-0">Sampai:</span>
                            <span class="text-gray-800" x-text="report.sampai || '-'"></span>
                        </div>
                    </>
                </template>
                <div class="flex">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">Print:</span>
                    <span class="text-gray-800" x-text="report.print || '-'"></span>
                </div>
                <div class="flex">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">Group:</span>
                    <span class="text-gray-800" x-text="report.grup || '-'"></span>
                </div>
            </div>

            {{-- Tombol Download PDF --}}
            <template x-if="report.file_path">
                <div class="flex items-center pt-3">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">File PDF:</span>
                    <span class="text-gray-800">
                        {{-- Ganti URL download ke tfp --}}
                        <a x-bind:href="`{{ url('tfp/save-data/download') }}/${report.id}`"
                            class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download PDF
                        </a>
                    </span>
                </div>
            </template>

            {{-- Detail Kegiatan (Harian) --}}
            <div x-show="report.type === 'Harian'" x-transition class="border-t pt-4 space-y-2">
                <h4 class="text-lg font-semibold text-gray-800">Detail Kegiatan</h4>
                <div x-show="loadingActivity" class="text-gray-500 italic">Memuat detail kegiatan...</div>
                <div x-show="!loadingActivity && activityError" class="text-red-500" x-text="activityError"></div>
                <div x-show="!loadingActivity && activity" x-transition class="grid grid-cols-2 gap-x-4 gap-y-1 text-base">
                    <div class="text-gray-500 font-medium">Kode:</div>
                    <div class="text-gray-800" x-text="activity?.kode || '-'"></div>
                    <div class="text-gray-500 font-medium">Dinas:</div>
                    <div class="text-gray-800" x-text="activity?.dinas || '-'"></div>
                    <div class="text-gray-500 font-medium">Waktu Mulai:</div>
                    <div class="text-gray-800" x-text="activity?.waktu_mulai || '-'"></div>
                    <div class="text-gray-500 font-medium">Waktu Selesai:</div>
                    <div class="text-gray-800" x-text="activity?.waktu_selesai || '-'"></div>
                    <div class="text-gray-500 font-medium">Alat:</div>
                    <div class="text-gray-800" x-text="activity?.alat || '-'"></div>
                    <div class="text-gray-500 font-medium">Permasalahan:</div>
                    <div class="text-gray-800" x-text="activity?.permasalahan || '-'"></div>
                    <div class="text-gray-500 font-medium">Tindakan:</div>
                    <div class="text-gray-800" x-text="activity?.tindakan || '-'"></div>
                    <div class="text-gray-500 font-medium">Hasil:</div>
                    <div class="text-gray-800" x-text="activity?.hasil || '-'"></div>
                    <div class="text-gray-500 font-medium">Status:</div>
                    <div class="text-gray-800" x-text="activity?.status || '-'"></div>
                    <div class="text-gray-500 font-medium">Teknisi:</div>
                    <div class="text-gray-800" x-text="activity?.teknisi_formatted || '-'"></div>
                    <div class="text-gray-500 font-medium">Waktu Putus:</div>
                    <div class="text-gray-800" x-text="activity?.waktu_putus || '-'"></div>
                    <div class="text-gray-500 font-medium">Lampiran:</div>
                    <div class="text-gray-800" x-text="activity?.lampiran_count > 0 ? activity?.lampiran_count + ' file' : '-'"></div>
                </div>
            </div>

            {{-- Detail Kegiatan (Bulanan) --}}
            <div x-show="report.type === 'Bulanan'" x-transition class="border-t pt-4 space-y-2">
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Detail Kegiatan</h4>
                <div x-show="loadingActivity" class="text-gray-500 italic">Memuat detail kegiatan...</div>
                <div x-show="!loadingActivity && activityError" class="text-red-500" x-text="activityError"></div>
                <div x-show="!loadingActivity && groupedActivities" class="space-y-2">
                    <template x-for="(activities, date) in groupedActivities" :key="date">
                        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden shadow-sm">
                            <button @click="open = !open" class="w-full flex justify-between items-center p-3 bg-gray-50 hover:bg-gray-100 transition-colors"> <span class="font-semibold text-base text-gray-800" x-text="(activities && activities.length > 0) ? activities[0].tanggal_display : 'Memuat Tanggal...'"></span>
                                <div class="flex items-center space-x-3"> <span class="text-sm text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full" x-text="activities.length + ' kegiatan'"></span> <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg> </div>
                            </button>
                            <div x-show="open" x-collapse class="p-4 space-y-4 bg-white">
                                <template x-for="(activity, index) in activities" :key="activity.id">
                                    <div>
                                        <hr x-show="index > 0" class="my-4 border-gray-200">
                                        <div class="grid grid-cols-3 gap-x-4 gap-y-1 text-base">
                                            <div class="col-span-1 text-gray-500 font-medium">Kode:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.kode || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Dinas:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.dinas || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Waktu Mulai:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.waktu_mulai || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Waktu Selesai:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.waktu_selesai || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Alat:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.alat || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Permasalahan:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.permasalahan || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Tindakan:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.tindakan || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Hasil:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.hasil || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Status:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.status || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Teknisi:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.teknisi_formatted || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Waktu Putus:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.waktu_putus || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Lampiran:</div>
                                            <div class="col-span-2 text-gray-800" x-text="activity.lampiran_count > 0 ? activity.lampiran_count + ' file' : '-'"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- >>> MODAL DETAIL JADWAL BULANAN <<< --}}
<div id="detail-jadwal-bulanan-modal"
    x-data="{
         showModal: false,
         report: { type_laporan: '', tanggal_mulai: '', tanggal_selesai: '', nama_alat: '' },
         groupedSchedules: null,
         loadingSchedule: false,
         scheduleError: ''
     }"
    x-show="showModal"
    x-on:open-jadwal-bulanan-modal.window="
         showModal = true;
         report = $event.detail.report;
         groupedSchedules = null; scheduleError = '';
         if (report.tanggal_mulai && report.tanggal_selesai) {
             loadingSchedule = true;
             if(typeof window.fetchMonthlyScheduleDetails === 'function') {
                window.fetchMonthlyScheduleDetails($data, report.tanggal_mulai, report.tanggal_selesai);
             } else {
                 console.error('Fungsi fetchMonthlyScheduleDetails tidak ditemukan.');
                 scheduleError = 'Error: Fungsi internal Bulanan tidak siap.';
                 loadingSchedule = false;
             }
         } else {
             scheduleError = 'Rentang tanggal laporan bulanan tidak lengkap.';
             loadingSchedule = false;
         }
     "
    x-on:keydown.escape.window="showModal = false"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 px-4"
    style="display: none;"
    aria-labelledby="modal-title-tfp-jadwal-bulanan" role="dialog" aria-modal="true"> {{-- Ganti ID --}}

    <div class="relative mx-auto p-6 border w-full max-w-xl shadow-lg rounded-xl bg-white"
        @click.outside="showModal = false">
        {{-- Header Modal --}}
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-jadwal-bulanan" class="text-xl font-semibold text-gray-900">Detail Jadwal Bulanan</h3> {{-- Ganti ID --}}
            <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        {{-- Konten Modal --}}
        <div class="text-base max-h-[70vh] overflow-y-auto pr-2 space-y-4">
            {{-- Info Laporan Bulanan --}}
            <div class="space-y-1">
                <div class="flex">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">Tipe Laporan:</span>
                    <span class="text-gray-800 font-semibold" x-text="report.type_laporan || '-'"></span>
                </div>
                <div class="flex">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">Nama Alat:</span>
                    <span class="text-gray-800" x-text="report.nama_alat || '-'"></span>
                </div>
                <div class="flex">
                    <span class="w-32 text-gray-500 font-medium flex-shrink-0">Periode:</span>
                    <span class="text-gray-800" x-text="report.tanggal_mulai + ' s/d ' + report.tanggal_selesai"></span>
                </div>
            </div>
            {{-- Daftar Jadwal (Bulanan) --}}
            <div class="border-t pt-4 mt-4 space-y-2">
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Daftar Jadwal</h4>
                <div x-show="loadingSchedule" class="text-gray-500 italic">Memuat detail jadwal...</div>
                <div x-show="!loadingSchedule && scheduleError" class="text-red-500" x-text="scheduleError"></div>
                {{-- Accordion Group --}}
                <div x-show="!loadingSchedule && groupedSchedules" class="space-y-2">
                    <template x-for="(schedules, date) in groupedSchedules" :key="date">
                        <div x-data="{ open: false }" class="border rounded-lg overflow-hidden shadow-sm">
                            {{-- Accordion Header (Clickable) --}}
                            <button @click="open = !open" class="w-full flex justify-between items-center p-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                                <span class="font-semibold text-base text-gray-800" x-text="(schedules && schedules.length > 0) ? schedules[0].tanggal_display : 'Memuat Tanggal...'">></span>
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full" x-text="schedules.length + ' jadwal'"></span>
                                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            {{-- Accordion Content (Collapsible) --}}
                            <div x-show="open" x-collapse class="p-4 space-y-4 bg-white">
                                <template x-for="(schedule, index) in schedules" :key="schedule.id">
                                    <div>
                                        <hr x-show="index > 0" class="my-4 border-gray-200">
                                        {{-- Schedule Details Grid --}}
                                        <div class="grid grid-cols-3 gap-x-4 gap-y-1 text-base">
                                            <div class="col-span-1 text-gray-500 font-medium">ID Jadwal:</div>
                                            <div class="col-span-2 text-gray-800" x-text="schedule.id_jadwal || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Dinas:</div>
                                            <div class="col-span-2 text-gray-800" x-text="schedule.dinas || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Teknisi 1:</div>
                                            <div class="col-span-2 text-gray-800" x-text="schedule.teknisi1 || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Teknisi 2:</div>
                                            <div class="col-span-2 text-gray-800" x-text="schedule.teknisi2 || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Teknisi 3:</div>
                                            <div class="col-span-2 text-gray-800" x-text="schedule.teknisi3 || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Kode:</div>
                                            <div class="col-span-2 text-gray-800" x-text="schedule.kode || '-'"></div>
                                            <div class="col-span-1 text-gray-500 font-medium">Grup:</div>
                                            <div class="col-span-2 text-gray-800" x-text="schedule.grup || '-'"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Fungsi UI (Sama)
    window.updateRadioButtonsUI = function(formElement) {
        formElement.querySelectorAll('.dinas-btn').forEach(b => {
            const val = b.dataset.dinas;
            const radioToCheck = formElement.querySelector(`input[name="dinas"][value="${val}"]`);
            if (radioToCheck) {
                b.classList.toggle('bg-indigo-600', radioToCheck.checked);
                b.classList.toggle('text-white', radioToCheck.checked);
                b.classList.toggle('bg-gray-100', !radioToCheck.checked);
                b.classList.toggle('text-gray-600', !radioToCheck.checked);
            }
        });
        formElement.querySelectorAll('.print-btn').forEach(b => {
            const val = b.dataset.print;
            const radioToCheck = formElement.querySelector(`input[name="print"][value="${val}"]`);
            if (radioToCheck) {
                b.classList.toggle('bg-indigo-600', radioToCheck.checked);
                b.classList.toggle('text-white', radioToCheck.checked);
                b.classList.toggle('bg-gray-100', !radioToCheck.checked);
                b.classList.toggle('text-gray-600', !radioToCheck.checked);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Logika modal tambah & edit (Sama)
        const openAddModalBtn = document.getElementById('add-savedata-btn');
        if (openAddModalBtn) {
            openAddModalBtn.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('open-modal'));
            });
        }
        const addModalForm = document.getElementById('add-savedata-form');
        if (addModalForm) {
            addModalForm.addEventListener('click', function(e) {
                let targetRadio = null;
                if (e.target.closest('.dinas-btn')) {
                    const btn = e.target.closest('.dinas-btn');
                    targetRadio = addModalForm.querySelector(`input[name="dinas"][value="${btn.dataset.dinas}"]`);
                } else if (e.target.closest('.print-btn')) {
                    const btn = e.target.closest('.print-btn');
                    targetRadio = addModalForm.querySelector(`input[name="print"][value="${btn.dataset.print}"]`);
                }
                if (targetRadio) {
                    targetRadio.checked = true;
                    window.updateRadioButtonsUI(addModalForm);
                }
            });
        }
        const editModalForm = document.getElementById('edit-savedata-form');
        if (editModalForm) {
            editModalForm.addEventListener('click', function(e) {
                let targetRadio = null;
                if (e.target.closest('.dinas-btn')) {
                    const btn = e.target.closest('.dinas-btn');
                    targetRadio = editModalForm.querySelector(`input[name="dinas"][value="${btn.dataset.dinas}"]`);
                } else if (e.target.closest('.print-btn')) {
                    const btn = e.target.closest('.print-btn');
                    targetRadio = editModalForm.querySelector(`input[name="print"][value="${btn.dataset.print}"]`);
                }
                if (targetRadio) {
                    targetRadio.checked = true;
                    window.updateRadioButtonsUI(editModalForm);
                }
            });
        }

        // --- LOGIKA FETCH DATA MODAL DETAIL (ROUTE DIGANTI KE TFP) ---

        // Fungsi fetch JADWAL (untuk modal icon Jadwal HARIAN)
        window.fetchScheduleDetails = async function(alpineData, tanggal, dinas) {
            if (!alpineData) {
                console.error('Alpine data not passed to fetchScheduleDetails');
                return;
            }
            alpineData.loadingSchedule = true;
            alpineData.scheduleError = '';
            try {
                // Ganti route ke TFP
                const response = await fetch(`{{ route('tfp.save_data.getSchedule') }}?tanggal=${tanggal}&dinas=${dinas}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal mengambil data jadwal.');
                const data = await response.json();
                if (data.success && data.schedule) {
                    alpineData.schedule = data.schedule;
                } else {
                    alpineData.scheduleError = data.message || 'Detail jadwal tidak ditemukan.';
                    alpineData.schedule = null;
                }
            } catch (error) {
                console.error('Error fetching schedule details:', error);
                alpineData.scheduleError = 'Gagal memuat detail jadwal.';
                alpineData.schedule = null;
            } finally {
                alpineData.loadingSchedule = false;
            }
        };

        // Fungsi fetch KEGIATAN (untuk modal icon Kegiatan HARIAN)
        window.fetchActivityDetails = async function(alpineData, tanggal, dinas) {
            if (!alpineData) {
                console.error('Alpine data not passed to fetchActivityDetails');
                return;
            }
            alpineData.loadingActivity = true;
            alpineData.activityError = '';
            try {
                // Ganti route ke TFP
                const response = await fetch(`{{ route('tfp.save_data.getActivity') }}?tanggal=${tanggal}&dinas=${dinas}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal mengambil data kegiatan.');
                const data = await response.json();
                if (data.success && data.activity) {
                    alpineData.activity = data.activity;
                } else {
                    alpineData.activityError = data.message || 'Detail kegiatan tidak ditemukan.';
                    alpineData.activity = null;
                }
            } catch (error) {
                console.error('Error fetching activity details:', error);
                alpineData.activityError = 'Gagal memuat detail kegiatan.';
                alpineData.activity = null;
            } finally {
                alpineData.loadingActivity = false;
            }
        };

        // Fungsi fetch KEGIATAN (untuk modal SUMMARY Harian)
        window.fetchSummaryActivityDetails = async function(alpineData, tanggal, dinas) {
            if (!alpineData) {
                console.error("Alpine data not passed to fetchSummaryActivityDetails.");
                return;
            }
            alpineData.loadingActivity = true;
            alpineData.activityError = '';
            try {
                // Ganti route ke TFP
                const response = await fetch(`{{ route('tfp.save_data.getActivity') }}?tanggal=${tanggal}&dinas=${dinas}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal mengambil data kegiatan.');
                const data = await response.json();
                if (data.success && data.activity) {
                    alpineData.activity = data.activity;
                } else {
                    alpineData.activityError = data.message || 'Detail kegiatan tidak ditemukan.';
                    alpineData.activity = null;
                }
            } catch (error) {
                console.error('Error fetching summary activity details:', error);
                alpineData.activityError = 'Gagal memuat detail kegiatan.';
                alpineData.activity = null;
            } finally {
                alpineData.loadingActivity = false;
            }
        };

        // Fungsi fetch KEGIATAN RENTANG TANGGAL (untuk modal SUMMARY Bulanan)
        window.fetchMonthlyActivityDetails = async function(alpineData, startDate, endDate) {
            if (!alpineData) {
                console.error("Alpine data not passed to fetchMonthlyActivityDetails.");
                return;
            }
            alpineData.loadingActivity = true;
            alpineData.activityError = '';
            alpineData.groupedActivities = null;
            try {
                // Ganti route ke TFP
                const response = await fetch(`{{ route('tfp.save_data.getRangeActivity') }}?start_date=${startDate}&end_date=${endDate}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal mengambil data kegiatan bulanan.');
                const data = await response.json();
                if (data.success && data.groupedActivities) {
                    alpineData.groupedActivities = data.groupedActivities;
                } else {
                    alpineData.activityError = data.message || 'Detail kegiatan tidak ditemukan.';
                    alpineData.groupedActivities = null;
                }
            } catch (error) {
                console.error('Error fetching monthly activity details:', error);
                alpineData.activityError = 'Gagal memuat detail kegiatan.';
                alpineData.groupedActivities = null;
            } finally {
                alpineData.loadingActivity = false;
            }
        };

        // Fungsi fetch JADWAL RENTANG TANGGAL (untuk modal Jadwal Bulanan)
        window.fetchMonthlyScheduleDetails = async function(alpineData, startDate, endDate) {
            if (!alpineData) {
                console.error("Alpine data not passed to fetchMonthlyScheduleDetails.");
                return;
            }
            alpineData.loadingSchedule = true;
            alpineData.scheduleError = '';
            alpineData.groupedSchedules = null;
            try {
                // Ganti route ke TFP
                const response = await fetch(`{{ route('tfp.save_data.getRangeSchedule') }}?start_date=${startDate}&end_date=${endDate}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal mengambil data jadwal bulanan.');
                const data = await response.json();
                if (data.success && data.groupedSchedules) {
                    alpineData.groupedSchedules = data.groupedSchedules;
                } else {
                    alpineData.scheduleError = data.message || 'Detail jadwal tidak ditemukan.';
                    alpineData.groupedSchedules = null;
                }
            } catch (error) {
                console.error('Error fetching monthly schedule details:', error);
                alpineData.scheduleError = 'Gagal memuat detail jadwal.';
                alpineData.groupedSchedules = null;
            } finally {
                alpineData.loadingSchedule = false;
            }
        };

    });
</script>
@endpush