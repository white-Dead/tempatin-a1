<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW place_rating_summary AS
            SELECT
                place_id,
                COUNT(review_id)                AS total_reviews,
                ROUND(AVG(rating_wifi), 2)      AS avg_wifi,
                ROUND(AVG(rating_comfort), 2)   AS avg_comfort,
                ROUND(AVG(rating_socket), 2)    AS avg_socket,
                ROUND(AVG(rating_overall), 2)   AS avg_overall
            FROM reviews
            WHERE is_verified = 1
            GROUP BY place_id
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS place_rating_summary');
    }
};
