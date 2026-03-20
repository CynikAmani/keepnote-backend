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
        Schema::create('todo_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();
            $table->foreignId('label_id')->nullable()->constrained()->onDelete('set null')->index();
            
            $table->string('title')->fullText();
            $table->string('color')->default('white');
            
            // State Management Fields
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_archived')->default(false);
            
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_groups');
    }
};
