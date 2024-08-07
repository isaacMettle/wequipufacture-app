<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoiceItemsTableNullable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // Modifier les colonnes existantes pour les rendre nullable
            $table->text('description')->nullable()->change();
            $table->decimal('prix_unitaire', 10, 2)->nullable()->change();
            $table->decimal('tva', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // Revenir aux colonnes non-nullable si nécessaire
            $table->text('description')->nullable(false)->change();
            $table->decimal('prix_unitaire', 10, 2)->nullable(false)->change();
            $table->decimal('tva', 5, 2)->nullable(false)->change();
        });
    }
}
