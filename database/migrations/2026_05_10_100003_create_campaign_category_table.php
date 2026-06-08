<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Pivot table untuk relasi Many to Many: Campaign <-> Category
    public function up(): void
    {
        Schema::create('campaign_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')
                  ->constrained('campaigns')
                  ->onDelete('cascade');
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_category');
    }
};
