<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('place_menu_item_photos', function (Blueprint $table) {
            $table->id('menu_item_photo_id');
            $table->unsignedBigInteger('menu_item_id');
            $table->string('photo_url');
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('menu_item_id')
                ->references('menu_item_id')
                ->on('place_menu_items')
                ->onDelete('cascade');

            $table->index(['menu_item_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_menu_item_photos');
    }
};
