<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            // L'utilisateur à l'origine du mouvement (gérant ou super admin)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Lien éventuel vers une vente
            $table->foreignId('sale_id')
                ->nullable()
                ->constrained('sales')
                ->nullOnDelete();

            $table->string('type'); // IN, OUT, ADJUSTMENT
            $table->integer('quantity');

            $table->integer('previous_stock')->default(0);
            $table->integer('new_stock')->default(0);

            $table->text('reason')->nullable(); // note, commentaire

            $table->timestamps();

            $table->index(['product_id', 'type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
