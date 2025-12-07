<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du bloc/magasin
            $table->string('code')->unique(); // Code unique du magasin (ex: BLC001)
            $table->text('address')->nullable(); // Adresse physique
            $table->string('city')->nullable(); // Ville
            $table->string('phone')->nullable(); // Téléphone du magasin
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
