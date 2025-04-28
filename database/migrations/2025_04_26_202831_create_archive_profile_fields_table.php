<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchiveProfileFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('archive_profile_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('archive_profile_id');
            $table->string('nom_champ');
            $table->string('type_champ'); // text, number, date, etc.
            $table->boolean('obligatoire')->default(false);
            $table->integer('ordre')->default(0);
            $table->timestamps();

            $table->foreign('archive_profile_id')->references('id')->on('type_archives')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('archive_profile_fields');
    }
}
