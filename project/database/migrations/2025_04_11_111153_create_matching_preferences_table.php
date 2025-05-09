<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchingPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matching_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offres')->onDelete('cascade');
            $table->boolean('use_ai')->default(false);
            $table->float('skills_weight')->nullable();
            $table->float('languages_weight')->nullable();
            $table->float('experience_weight')->nullable();
            $table->float('location_weight')->nullable();
            $table->timestamps();
            $table->unique('offer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matching_preferences');
    }
}
