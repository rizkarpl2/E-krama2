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
        Schema::create('m_dokumens', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->string('nm_dokumen');
            $table->date('tgl_input');
            $table->string('penulis');
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
        Schema::dropIfExists('m_dokumens');
    }
};
