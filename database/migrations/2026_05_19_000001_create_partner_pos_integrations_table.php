<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_pos_integrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->enum('provider', ['moka', 'pawoon', 'lainnya']);
            $table->text('api_key')->nullable();
            $table->string('outlet_id')->nullable();
            $table->string('webhook_secret')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('partner_id')->on('partners')->onDelete('cascade');
            $table->unique('partner_id');
            $table->index(['partner_id', 'provider']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_pos_integrations');
    }
};
