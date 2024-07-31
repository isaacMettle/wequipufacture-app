<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyInvoicesColumnsNullable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Modifier les colonnes existantes pour les rendre nullable
            $table->string('invoice_number')->nullable()->change();
            $table->date('due_date')->nullable()->change();
            $table->text('note')->nullable()->change();
            $table->text('email_text')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->decimal('total', 10, 2)->nullable()->change();
            $table->enum('statut', ['payer', 'non payé'])->default('non payé')->nullable()->change();
            $table->enum('approbation', ['valide', 'non valide'])->default('non valide')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Revenir aux colonnes non nullable
            $table->string('invoice_number')->nullable(false)->change();
            $table->date('due_date')->nullable(false)->change();
            $table->text('note')->nullable(false)->change();
            $table->text('email_text')->nullable(false)->change();
            $table->enum('statut', ['payer', 'non payé'])->default('non payé')->nullable(false)->change();
            $table->enum('approbation', ['valide', 'non valide'])->default('non valide')->nullable(false)->change();
            $table->date('date')->nullable()->change();
            $table->decimal('total', 10, 2)->nullable()->change();
        });
    }
}

