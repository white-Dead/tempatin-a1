<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('place_id');
            $table->tinyInteger('rating_wifi')->nullable();
            $table->tinyInteger('rating_comfort')->nullable();
            $table->tinyInteger('rating_socket')->nullable();
            $table->tinyInteger('rating_overall');
            $table->text('comment')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('place_id')->references('place_id')->on('places')->onDelete('cascade');
            $table->unique(['user_id', 'place_id'], 'one_review_per_user');
            $table->index(['place_id', 'is_verified']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
