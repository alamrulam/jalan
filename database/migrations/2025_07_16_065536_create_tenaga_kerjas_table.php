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
    Schema::create('tenaga_kerjas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->string('nama_pekerja');
        $table->string('alamat_pekerja')->nullable();
        $table->string('posisi'); // Contoh: Tukang, Pekerja, Mandor
        $table->decimal('honor_harian', 15, 2); // Angka besar untuk honor
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kerjas');
    }
};
