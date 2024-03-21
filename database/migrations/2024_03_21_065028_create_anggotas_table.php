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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->unsignedBigInteger('id_divisi');
            $table->unsignedBigInteger('id_jabatan');
            $table->string('nm_anggota');
            $table->string('email');
            $table->string('alamat');
            $table->string('no_tlp');
            $table->date('tgl_lahir');
            $table->date('tgl_bergabung');
           
            $table->timestamps();
            
            // Menambahkan foreign key untuk id_divisi
            $table->foreign('id_divisi')->references('id_divisi')->on('divisis')->onDelete('restrict');
            
            // Menambahkan foreign key untuk id_jabatan
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
