<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Perintah ini HANYA MENGUBAH tabel, tidak membuat baru
        Schema::table('work_orders', function (Blueprint $table) {
            // Tambahkan 3 kolom baru setelah kolom 'deskripsi'
            $table->string('pelaksana_tipe')->nullable()->after('deskripsi');
            $table->string('pelaksana_nama')->nullable()->after('pelaksana_tipe');
            $table->string('pelaksana_group')->nullable()->after('pelaksana_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['pelaksana_tipe', 'pelaksana_nama', 'pelaksana_group']);
        });
    }
};
