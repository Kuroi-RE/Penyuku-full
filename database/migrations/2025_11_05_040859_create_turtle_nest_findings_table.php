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
        Schema::create('turtle_nest_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin penangkaran yang input
            $table->date('finding_date'); // Tanggal temuan
            $table->string('nest_code')->nullable(); // Kode sarang (P1, P2, dst) - nullable jika diambil nelayan
            $table->integer('egg_count'); // Jumlah telur
            $table->string('location'); // Tempat temuan (nama pantai)
            $table->date('estimated_hatching_date')->nullable(); // Perkiraan menetas
            $table->integer('hatched_count')->default(0); // Jumlah yang menetas
            $table->decimal('hatching_percentage', 5, 2)->default(0); // Persentase penetasan
            $table->enum('status', ['monitoring', 'hatched', 'taken_by_fisherman'])->default('monitoring'); // Status
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turtle_nest_findings');
    }
};
