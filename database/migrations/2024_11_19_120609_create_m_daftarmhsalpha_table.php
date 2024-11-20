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
        Schema::create('m_daftarmhsalpha', function (Blueprint $table) {
            $table->id('daftarmhsalpha_id'); // AUTO_INCREMENT & primary key
            $table->unsignedBigInteger('mahasiswa_id');
            $table->integer('jumlah_jamalpha');
            $table->string('periode', 100);
            $table->string('prodi', 50);
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_usermahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_daftarmhsalpha');
    }
};
