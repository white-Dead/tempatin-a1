<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id('place_id');
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->string('place_name', 150);
            $table->enum('category', ['cafe', 'coworking', 'restoran', 'perpustakaan', 'lainnya'])->default('cafe');
            $table->text('address');
            $table->string('city', 100);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('price_range', 50)->nullable()->comment('e.g. 10000-30000');
            $table->string('opening_hours', 255)->nullable()->comment('e.g. 08:00-22:00');
            $table->text('description')->nullable();
            $table->enum('noise_level', ['tenang', 'sedang', 'ramai'])->default('sedang');
            $table->enum('status', ['active', 'inactive', 'pending_review'])->default('pending_review');
            $table->tinyInteger('data_completeness_score')->default(0);
            $table->string('cover_photo_url')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('partner_id')->on('partners')->onDelete('set null');

            $table->index('city');
            $table->index('status');
            $table->index(['latitude', 'longitude']);
            $table->index(['status', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
