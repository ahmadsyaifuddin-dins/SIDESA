<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 50)->nullable()->after('id');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(false)->after('jabatan');
            $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('no_hp', 17)->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'no_hp', 'jenis_kelamin', 'tanggal_lahir', 'alamat']);
        });
    }
};