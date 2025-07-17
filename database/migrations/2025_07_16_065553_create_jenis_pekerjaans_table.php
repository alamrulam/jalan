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
    Schema::create('jenis_pekerjaans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->string('nama_pekerjaan'); // Contoh: Pekerjaan Saluran Drainase
        $table->text('deskripsi')->nullable();
        $table->integer('progres')->default(0); // Progres dalam persen (0-100)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pekerjaans');
    }
};
