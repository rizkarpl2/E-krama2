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
        Schema::create('kas_masuks', function (Blueprint $table) {
            $table->id('id_kasmasuk');
            $table->foreignId('user_id')->constrained('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nm_pj');//nama penangung jawab
            $table->date('tgl_input');
            $table->string('nominal');
            $table->string('ket');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_masuks');
    }
};
