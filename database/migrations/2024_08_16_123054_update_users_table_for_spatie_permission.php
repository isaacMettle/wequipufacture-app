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
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la colonne role_id
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');

            // Ajouter les colonnes email_verified_at et remember_token
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ajouter à nouveau la colonne role_id
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('cascade');

            // Supprimer les colonnes email_verified_at et remember_token
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
        });
    }
};
