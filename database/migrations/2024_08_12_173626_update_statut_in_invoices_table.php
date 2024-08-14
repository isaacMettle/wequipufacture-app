<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatutInInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Supprimer la colonne 'statut' existante
            $table->dropColumn('statut');
        });

        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter la colonne 'statut' avec la nouvelle valeur 'envoyé'
            $table->enum('statut', ['payer', 'non payé', 'envoyé'])->default('non payé')->nullable();
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Supprimer la colonne 'statut' existante
            $table->dropColumn('statut');
        });

        Schema::table('invoices', function (Blueprint $table) {
            // Revenir à l'ancienne version de la colonne 'statut' sans la valeur 'envoyé'
            $table->enum('statut', ['payer', 'non payé'])->default('non payé')->nullable();
        });
    }
}
