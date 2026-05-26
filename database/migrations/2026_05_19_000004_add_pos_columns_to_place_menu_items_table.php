<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('place_menu_items', function (Blueprint $table) {
            $table->enum('source', ['manual', 'moka', 'pawoon'])->default('manual')->after('sort_order');
            $table->boolean('is_available')->default(true)->after('source');
            $table->string('external_id')->nullable()->after('is_available');
            $table->timestamp('last_synced_at')->nullable()->after('external_id');

            $table->index(['source', 'external_id']);
        });
    }

    public function down(): void
    {
        Schema::table('place_menu_items', function (Blueprint $table) {
            $table->dropIndex(['source', 'external_id']);
            $table->dropColumn(['source', 'is_available', 'external_id', 'last_synced_at']);
        });
    }
};
