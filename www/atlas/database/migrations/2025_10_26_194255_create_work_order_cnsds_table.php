<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_cnsds', function (Blueprint $table) {
            $table->id();
            $table->string('wo_id_custom')->unique()->nullable(); // Untuk nomor WO-CNSD-000X
            $table->string('tertuju')->default('CNSD');
            $table->string('shift')->nullable();
            $table->text('shift_dinas_nama')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('jam_display')->nullable();
            $table->text('deskripsi')->nullable();
            $table->json('output')->nullable(); // Menyimpan array output sebagai JSON
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('status_pelaksanaan')->nullable();
            $table->text('catatan_kendala')->nullable();
            $table->text('usulan')->nullable();
            $table->text('catatan_pemberi_tugas')->nullable();
            $table->string('verify_manager')->nullable();
            $table->string('verify_supervisor')->nullable();
            $table->string('verify_pelaksana')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_cnsds');
    }
};