<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique(); // Référence interne
            $table->string('barcode')->nullable(); // Code-barres éventuel
            $table->text('description')->nullable();

            $table->decimal('purchase_price', 15, 2); // Prix d’achat
            $table->decimal('sale_price', 15, 2);     // Prix de vente

            // Stock actuel et seuil d’alerte
            $table->integer('current_stock')->default(0);
            $table->integer('stock_alert_threshold')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Index pour recherches rapides
            $table->index(['name', 'sku', 'barcode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
