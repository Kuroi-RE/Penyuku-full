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
        Schema::create('turtle_nesting_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin penangkaran yang input
            $table->string('location_name'); // Nama lokasi pantai
            $table->enum('month', ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']); // Bulan
            $table->year('year'); // Tahun
            $table->integer('nesting_count')->default(0); // Jumlah peneluran
            $table->text('notes')->nullable(); // Catatan
            $table->timestamps();
            
            // Index untuk query lebih cepat
            $table->index(['location_name', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turtle_nesting_locations');
    }
};
