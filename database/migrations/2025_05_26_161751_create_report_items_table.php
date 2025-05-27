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
        Schema::create('report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_report_id')->constrained()->onDelete('cascade'); // Relasi ke tabel daily_reports
            $table->string('jenis_pekerjaan');
            $table->decimal('panjang', 8, 2)->nullable();
            $table->decimal('lebar', 8, 2)->nullable();
            $table->decimal('tinggi_atau_tebal', 8, 2)->nullable();
            $table->decimal('volume_dihitung', 10, 2);
            $table->string('satuan_volume')->default('m³'); // Atau bisa juga m² tergantung jenis pekerjaan
            $table->text('catatan_item')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_items');
    }
};
