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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom-kolom baru kita setelah kolom 'email'
            $table->string('jabatan')->nullable()->after('email');
            $table->string('profile_photo_path')->nullable()->after('password');
            $table->enum('role', ['superadmin', 'admin'])->default('admin')->after('profile_photo_path');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif')->after('role');
            $table->timestamp('last_login_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom-kolom yang kita tambahkan jika migrasi di-rollback
            $table->dropColumn([
                'jabatan',
                'profile_photo_path',
                'role',
                'status',
                'last_login_at',
            ]);
        });
    }
};