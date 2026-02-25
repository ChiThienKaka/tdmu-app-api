<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE EXTENSION IF NOT EXISTS vector");

        DB::statement("
            CREATE TABLE embeddings (
                id SERIAL PRIMARY KEY,
                source_table TEXT,
                source_id INT,
                content TEXT,
                content_hash VARCHAR(64),
                embedding VECTOR(768)
            )
        ");

        DB::statement("
            CREATE UNIQUE INDEX embeddings_content_hash_unique
            ON embeddings (content_hash)
        ");

        DB::statement("
            CREATE INDEX embeddings_source_idx
            ON embeddings (source_table, source_id)
        ");

        DB::statement("
            CREATE INDEX embeddings_vector_idx
            ON embeddings
            USING ivfflat (embedding vector_cosine_ops)
            WITH (lists = 100)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embeddings');
    }
};
