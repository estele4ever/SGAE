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
    Schema::create('archives', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->text('description')->nullable();
        $table->string('type_id');
        $table->string('service_id');
        $table->string('metadata');
        $table->string('fichier')->nullable(); // Stockera le chemin du fichier
        $table->timestamps('deleted_at'); // Pour enregistrer la date de création
        $table->timestamps(); // Pour enregistrer la date de création
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
    
};
