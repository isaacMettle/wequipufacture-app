<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToInvoiceItemsTable extends Migration
{
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->text('description')->after('id');  // assuming 'id' is the first column, adjust accordingly
            $table->decimal('prix_unitaire', 10, 2)->after('description');
            $table->decimal('tva', 5, 2)->after('prix_unitaire');
        });
    }

    public function down()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('prix_unitaire');
            $table->dropColumn('tva');
        });
    }
}
