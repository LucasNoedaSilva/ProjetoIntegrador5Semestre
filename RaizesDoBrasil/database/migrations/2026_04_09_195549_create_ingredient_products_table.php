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
        Schema::create('ingredient_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')
              ->constrained('products') 
              ->onDelete('cascade');
            $table->foreignId('ingredient_id')
              ->constrained('ingredients') 
              ->onDelete('cascade');
            $table->Integer("amount");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredient_products');
    }
};
