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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('invoice_number')->nullable()->change();
            $table->date('due_date')->nullable()->change();
            $table->text('note')->nullable()->change();
            $table->text('email_text')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->decimal('total', 10, 2)->nullable()->change();
            $table->double('sub_total', 15, 2)->default(0.00)->after('total');
            $table->enum('statut', ['payer', 'non payé'])->default('non payé')->nullable()->change();
            $table->enum('approbation', ['valide', 'non valide'])->default('non valide')->nullable()->change();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
