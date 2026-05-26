<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('partner_pos_integrations')->cascadeOnDelete();
            $table->enum('sync_type', ['manual', 'webhook', 'scheduled']);
            $table->enum('status', ['success', 'failed', 'partial']);
            $table->unsignedInteger('items_synced')->default(0);
            $table->text('error_message')->nullable();
            $table->timestamp('synced_at');

            $table->index(['integration_id', 'synced_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_sync_logs');
    }
};
