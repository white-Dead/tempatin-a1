<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favorite_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('place_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('place_id')->references('place_id')->on('places')->onDelete('cascade');
            $table->unique(['user_id', 'place_id']);
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('place_id')->nullable();
            $table->enum('action_type', ['view_profile', 'click_route', 'click_contact', 'click_promo']);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['place_id', 'action_type', 'created_at']);
        });

        Schema::create('place_photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->unsignedBigInteger('place_id');
            $table->string('photo_url');
            $table->boolean('is_cover')->default(false);
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('place_id')->references('place_id')->on('places')->onDelete('cascade');
            $table->index(['place_id', 'is_cover']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_photos');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('favorites');
    }
};
