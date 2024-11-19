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
        Schema::create('m_daftarmhskompen', function (Blueprint $table) {
            $table->id('daftarmhskompen_id'); // AUTO_INCREMENT & primary key
            $table->unsignedBigInteger('daftarmhsalpha_id');
            $table->integer('jumlah_jam_telah_dikerjakan');
            $table->timestamps();

            $table->foreign('daftarmhsalpha_id')->references('daftarmhsalpha_id')->on('m_daftarmhsalpha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_daftarmhskompen');
    }
};
