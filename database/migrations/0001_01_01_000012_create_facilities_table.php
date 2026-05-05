<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id('facility_id');
            $table->string('facility_name', 100)->unique();
            $table->string('label', 100);
            $table->string('icon_name', 50)->nullable();
        });

        Schema::create('place_facilities', function (Blueprint $table) {
            $table->id('place_facility_id');
            $table->unsignedBigInteger('place_id');
            $table->unsignedBigInteger('facility_id');
            $table->string('notes', 255)->nullable();

            $table->foreign('place_id')->references('place_id')->on('places')->onDelete('cascade');
            $table->foreign('facility_id')->references('facility_id')->on('facilities');
            $table->unique(['place_id', 'facility_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_facilities');
        Schema::dropIfExists('facilities');
    }
};
