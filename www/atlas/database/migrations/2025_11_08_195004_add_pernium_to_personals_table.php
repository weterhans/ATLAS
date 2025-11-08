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
        Schema::table('personals', function (Blueprint $table) {
            $table->dropColumn('pernium');
        });
    }
    public function down(): void
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->string('pernium')->nullable()->unique()->after('nik');
        });
    }
};
