<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTemporaryValuesToApprobationInInvoicesTable extends Migration
{
    public function up()
    {
        // Add the temporary new values
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('approbation', ['valide', 'non valide', 'approuver', 'non approuver', 'en attente'])->default('en attente')->change();
        });

        // Update existing values
        DB::table('invoices')->where('approbation', 'valide')->update(['approbation' => 'approuver']);
        DB::table('invoices')->where('approbation', 'non valide')->update(['approbation' => 'non approuver']);
    }

    public function down()
    {
        // Revert the values to their previous state
        DB::table('invoices')->where('approbation', 'approuver')->update(['approbation' => 'valide']);
        DB::table('invoices')->where('approbation', 'non approuver')->update(['approbation' => 'non valide']);

        // Revert to previous enum values
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('approbation', ['valide', 'non valide'])->default('non valide')->change();
        });
    }
}
