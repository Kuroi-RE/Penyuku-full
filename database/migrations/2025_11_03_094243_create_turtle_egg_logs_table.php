<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('turtle_egg_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logger_user_id')->constrained('users')->onDelete('cascade');
            $table->string('species');
            $table->string('nest_location');
            $table->date('date_found');
            $table->integer('quantity_found');
            $table->date('estimated_hatch_date');
            $table->integer('quantity_hatched')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turtle_egg_logs');
    }
};