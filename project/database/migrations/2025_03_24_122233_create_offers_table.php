<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->integer('nombre_poste');
            $table->string('type_contrat');
            $table->string('mode_travail');
            $table->text('description');
            $table->date('date_expiration')->nullable();
            $table->integer('salaire');
            $table->integer('experience');
            $table->string('location');
            $table->string('statut');
            $table->integer('candidatures_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
