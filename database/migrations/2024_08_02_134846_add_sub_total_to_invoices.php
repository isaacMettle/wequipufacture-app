<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubTotalToInvoices extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter la colonne sub_total de type double avec une valeur par défaut de 0.00
            $table->double('sub_total', 15, 2)->default(0.00)->after('total');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Supprimer la colonne sub_total si la migration est annulée
            $table->dropColumn('sub_total');
        });
    }
}
