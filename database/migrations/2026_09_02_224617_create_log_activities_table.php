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
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (Nullable jika pencatatan gagal login user tidak ditemukan)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('subject');        // Jenis aktivitas (Contoh: Login, Logout, Failed Login)
            $table->string('url');            // URL yang diakses saat aktivitas terjadi
            $table->string('method', 10);     // HTTP Method (GET, POST, dsb)
            $table->string('ip_address', 45); // Alamat IP pengguna (IPv4 / IPv6)
            $table->text('agent');            // Informasi Browser & OS (User Agent)
            
            $table->timestamps();             // created_at (sebagai Waktu Akses Log)

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
