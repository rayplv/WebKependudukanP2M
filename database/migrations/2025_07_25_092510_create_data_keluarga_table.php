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
        Schema::create('data_keluarga', function (Blueprint $table) {
            $table->string('no_kk', 20)->primary();
            $table->text('alamat');
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('desa', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->date('tanggal_dikeluarkan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_keluarga');
    }
};
