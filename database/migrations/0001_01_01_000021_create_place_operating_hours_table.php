<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('place_operating_hours', function (Blueprint $table) {
            $table->id('operating_hour_id');
            $table->unsignedBigInteger('place_id');
            $table->unsignedTinyInteger('day_of_week');
            $table->time('opens_at')->nullable();
            $table->time('closes_at')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();

            $table->foreign('place_id')->references('place_id')->on('places')->onDelete('cascade');
            $table->unique(['place_id', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_operating_hours');
    }
};
