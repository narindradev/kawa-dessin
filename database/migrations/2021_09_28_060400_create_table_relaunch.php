<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRelaunch extends Migration
{
    private $table = "relaunchs";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->text("description");
            $table->bigInteger("project_id")->nullable();
            $table->bigInteger("created_by")->nullable();
            $table->timestamps();
        });
        $this->seed();
    }
    private function seed(){
        DB::table($this->table)->insert([
                ["description" => "Etude de devis"],
                ["description" => "Négociation de devis"],
                ["description" => "Paiment pour le 1ér tranche"],
                ["description" => "Paiment pour le 2èm tranche"],
            ]
        );
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
