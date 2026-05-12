<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('place_menu_items', function (Blueprint $table) {
            $table->id('menu_item_id');
            $table->unsignedBigInteger('place_id');
            $table->string('menu_name', 150);
            $table->string('category', 50)->nullable();
            $table->unsignedInteger('price');
            $table->string('photo_url')->nullable();
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('place_id')->references('place_id')->on('places')->onDelete('cascade');
            $table->index(['place_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_menu_items');
    }
};
