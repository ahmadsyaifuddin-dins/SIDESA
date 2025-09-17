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
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            // Sekarang kita tambahkan foreign key-nya
            $table->foreign('kepala_keluarga_id')
                  ->references('id')
                  ->on('warga')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            // Hapus foreign key jika rollback
            $table->dropForeign(['kepala_keluarga_id']);
        });
    }
};
