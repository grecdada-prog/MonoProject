<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // Vendeur qui a créé la vente
            $table->foreignId('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Gérant superviseur (optionnel)
            $table->foreignId('manager_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->integer('total_items')->default(0);

            $table->decimal('total_amount', 15, 2)->default(0); // Total TTC facturé
            $table->decimal('total_cost', 15, 2)->default(0);   // Coût d’achat des produits
            $table->decimal('profit', 15, 2)->default(0);       // Bénéfice (total_amount - total_cost)

            $table->string('status')->default('COMPLETED'); // COMPLETED, CANCELLED, REFUNDED...
            $table->string('payment_method')->nullable();    // CASH, CARD, MOBILE_MONEY...

            $table->timestamp('sold_at')->nullable();

            // Infos techniques pour traçabilité
            $table->string('client_name')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('invoice_number')->unique(); // Pour la facture

            $table->string('created_ip')->nullable();
            $table->string('created_user_agent')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['seller_id', 'manager_id', 'sold_at', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
