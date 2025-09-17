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
        Schema::create('warga', function (Blueprint $table) {
            // --- Kolom Utama & Kunci ---
            $table->id();
            $table->foreignId('kartu_keluarga_id')
                  ->comment('Menghubungkan warga ke tabel kartu_keluarga')
                  ->constrained('kartu_keluarga')
                  ->onDelete('cascade');

            // --- Data Diri Sesuai Dukcapil ---
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('status_perkawinan');
            $table->string('status_hubungan_keluarga');
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('golongan_darah', 3)->nullable();

            // --- Data Orang Tua ---
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();

            // --- Status Aktif Warga ---
            $table->boolean('aktif')->default(true)->comment('Status apakah warga masih tercatat aktif di desa');
            
            // --- Keterangan Tambahan ---
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};

