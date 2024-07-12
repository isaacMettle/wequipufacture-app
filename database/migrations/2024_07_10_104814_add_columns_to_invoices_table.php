<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('statut', ['payer', 'non payé'])->default('non payé');
            $table->enum('approbation', ['valide', 'non valide'])->default('non valide')->after('statut');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('statut');
            $table->dropColumn('approbation');
        });
    }
}
