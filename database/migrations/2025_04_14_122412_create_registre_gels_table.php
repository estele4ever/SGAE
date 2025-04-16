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
        Schema::create('registre_gels', function (Blueprint $table) {
            $table->id();
            $table->string('archive_id')->unique();
            $table->string('motif')->nullable();
            $table->string('permissions')->nullable(); // JSON or comma-separated values
            $table->boolean('statut')->default(true);
            $table->string('duree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registre_gels');
    }
};
