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
        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_group_id')->constrained()->cascadeOnDelete();
            
            $table->string('task');
            $table->boolean('is_completed')->default(false);
            $table->integer('position')->default(0); // For drag-and-drop ordering
            
            $table->timestamps();

            $table->index('todo_group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_items');
    }
};
