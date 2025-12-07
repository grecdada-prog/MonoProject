<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_id')
                ->constrained('sales')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->integer('quantity')->default(1);

            $table->decimal('unit_price', 15, 2);   // Prix de vente unitaire
            $table->decimal('total_price', 15, 2);  // unit_price * quantity

            $table->decimal('unit_cost', 15, 2);    // Prix d’achat unitaire
            $table->decimal('total_cost', 15, 2);   // unit_cost * quantity

            $table->timestamps();

            $table->index(['sale_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
