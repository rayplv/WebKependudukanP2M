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
        Schema::create('data_pribadi', function (Blueprint $table) {
            $table->string('nik', 20)->primary();
            $table->string('no_kk_id', 20)->nullable();
            $table->foreign('no_kk_id')->references('no_kk')->on('data_keluarga')->onDelete('set null');
            $table->unsignedInteger('hubungan_keluarga_id')->nullable();
            $table->foreign('hubungan_keluarga_id')->references('id')->on('hubungan_keluarga')->onDelete('set null');
            $table->string('nama', 100);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN'])->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-'])->nullable();
            $table->unsignedInteger('agama_id')->nullable();
            $table->foreign('agama_id')->references('id')->on('agama')->onDelete('set null');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            $table->date('tanggal_perkawinan')->nullable();
            $table->date('tanggal_perceraian')->nullable();
            $table->unsignedInteger('pendidikan_terakhir_id')->nullable();
            $table->foreign('pendidikan_terakhir_id')->references('id')->on('pendidikan_terakhir')->onDelete('set null');
            $table->unsignedInteger('pekerjaan_id')->nullable();
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaan')->onDelete('set null');
            $table->enum('kewarganegaraan', ['WNI', 'WNA'])->default('WNI');
            $table->boolean('penyandang_disabilitas')->default(false);
            $table->string('nama_ayah', 100)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pribadi');
    }
};
