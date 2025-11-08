<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            // Ini adalah kunci untuk menghubungkan WO ke seorang staf
            $table->foreignId('personal_id')->constrained('personals')->onDelete('cascade');

            $table->date('tanggal');
            $table->string('fasilitas'); // Kategori
            $table->string('jenis');
            $table->text('deskripsi')->nullable();

            $table->string('pelaksana_tipe')->nullable(); // Personal atau Group
            $table->string('pelaksana_nama')->nullable(); // Nama jika Personal
            $table->string('pelaksana_group')->nullable(); // Nama jika Group

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['pelaksana_tipe', 'pelaksana_nama', 'pelaksana_group']);
        });
    }
};
