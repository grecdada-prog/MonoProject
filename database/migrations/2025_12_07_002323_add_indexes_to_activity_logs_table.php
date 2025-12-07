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
        Schema::table('activity_logs', function (Blueprint $table) {
            // Index pour améliorer les performances des requêtes
            $table->index('user_id', 'idx_activity_logs_user_id');
            $table->index('action', 'idx_activity_logs_action');
            $table->index('created_at', 'idx_activity_logs_created_at');

            // Index composite pour les requêtes fréquentes
            $table->index(['user_id', 'created_at'], 'idx_activity_logs_user_date');
            $table->index(['action', 'created_at'], 'idx_activity_logs_action_date');

            // Index pour subject polymorphique
            $table->index(['subject_type', 'subject_id'], 'idx_activity_logs_subject');
        });

        // Note: Pour le partitioning PostgreSQL par date, exécuter manuellement:
        // ALTER TABLE activity_logs PARTITION BY RANGE (created_at);
        // CREATE TABLE activity_logs_2025 PARTITION OF activity_logs
        //     FOR VALUES FROM ('2025-01-01') TO ('2026-01-01');
        // (Voir documentation: PARTITIONING.md)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('idx_activity_logs_user_id');
            $table->dropIndex('idx_activity_logs_action');
            $table->dropIndex('idx_activity_logs_created_at');
            $table->dropIndex('idx_activity_logs_user_date');
            $table->dropIndex('idx_activity_logs_action_date');
            $table->dropIndex('idx_activity_logs_subject');
        });
    }
};
