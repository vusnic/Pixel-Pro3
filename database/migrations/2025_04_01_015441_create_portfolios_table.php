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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->string('category')->default('web');
            $table->text('technologies')->nullable();
            $table->string('client_name')->nullable();
            $table->string('project_url')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('highlights')->nullable(); // Armazenar destaques como JSON
            $table->integer('order')->default(0);
            $table->boolean('featured')->default(false);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
