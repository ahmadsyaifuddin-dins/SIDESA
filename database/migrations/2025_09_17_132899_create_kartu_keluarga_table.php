<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kk', 16)->unique();
            
            // Kita hanya siapkan kolomnya dulu, tanpa foreign key
            $table->unsignedBigInteger('kepala_keluarga_id')->nullable();

            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('kode_pos', 5)->nullable();
            $table->string('desa_kelurahan')->default('ANJIR MUARA KOTA TENGAH');
            $table->string('kecamatan')->default('ANJIR MUARA');
            $table->string('kabupaten_kota')->default('KAB. BARITO KUALA');
            $table->string('provinsi')->default('KALIMANTAN SELATAN');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_keluarga');
    }
};