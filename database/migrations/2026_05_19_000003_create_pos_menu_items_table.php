<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_item_id')->nullable();
            $table->string('pos_item_id');
            $table->string('pos_item_name');
            $table->unsignedInteger('pos_price');
            $table->string('pos_category')->nullable();
            $table->boolean('pos_is_available')->default(true);
            $table->timestamp('fetched_at');
            $table->timestamps();

            $table->foreign('menu_item_id')->references('menu_item_id')->on('place_menu_items')->onDelete('cascade');
            $table->index('pos_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_menu_items');
    }
};
