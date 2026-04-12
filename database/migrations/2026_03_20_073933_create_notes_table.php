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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Fast lookup for a user's notes
            $table->foreignId('label_id')->nullable()->constrained()->nullOnDelete(); // Fast lookup for notes by label
            
            $table->string('title')->fullText(); // Index for faster search by title;
            $table->text('content')->nullable()->fullText(); // Full-text index for content search
            $table->string('color')->default('white');
            
            // State Management Fields
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_archived')->default(false);
            
            $table->timestamps();
            $table->softDeletes(); // This adds a 'deleted_at' column for "is_deleted" logic

            $table->index('user_id');
            $table->index('label_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
