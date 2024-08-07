<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApprobationFinalInInvoicesTable extends Migration
{
    public function up()
    {
        // Finalize the column enum values
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('approbation', ['approuver', 'non approuver', 'en attente'])->default('en attente')->change();
        });
    }

    public function down()
    {
        // Revert to the temporary enum values
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('approbation', ['valide', 'non valide', 'approuver', 'non approuver', 'en attente'])->default('non valide')->change();
        });
    }
}
