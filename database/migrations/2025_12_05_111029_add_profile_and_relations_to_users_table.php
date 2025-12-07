<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profil de base
            $table->string('username')->unique()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar_path')->nullable()->after('phone');

            // Lien vers le gérant pour les vendeurs
            $table->foreignId('manager_id')
                ->nullable()
                ->after('avatar_path')
                ->constrained('users')
                ->nullOnDelete();

            // Champs pour 2FA (style Laravel Fortify / Jetstream)
            $table->text('two_factor_secret')->nullable()->after('remember_token');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');

            // Soft deletes pour pouvoir récupérer des comptes supprimés
            $table->softDeletes()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On supprime les colonnes ajoutées
            $table->dropForeign(['manager_id']);
            $table->dropColumn([
                'username',
                'phone',
                'avatar_path',
                'manager_id',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
                'deleted_at',
            ]);
        });
    }
};
