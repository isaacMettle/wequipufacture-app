<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->decimal('total', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('description')->nullable(false)->change();
            $table->integer('quantity')->nullable(false)->change();
            $table->decimal('total', 8, 2)->nullable(false)->change();
        });
    }
};
