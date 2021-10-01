<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInfoGround extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_grounds', function (Blueprint $table) {
            $table->id();
            $table->integer("project_id")->nullable();
            $table->text("street_number")->nullable();
            $table->text("place_said")->nullable();
            $table->text("zip")->nullable();
            $table->text("community")->nullable();
            $table->text("section")->nullable();
            $table->text("parcel")->nullable();

            $table->boolean("lotissement")->default(0);
            $table->boolean("copropriete")->default(0);
            $table->boolean("eau_pluie")->default(0);
            $table->boolean("eau_potable")->default(0);
            $table->boolean("elec")->default(0);
            $table->boolean("gaz")->default(0);
            $table->boolean("assainissement")->default(0);
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
        Schema::dropIfExists('info_grounds');
    }
}
