<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table = "user_type";
  
    public function up()
    {
      
        $this->down();
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description")->nullable();
            $table->timestamps();
        });
        $this->seed();
    }

    private function seed(){
        DB::table($this->table)->insert([
                ['name' => 'admin' ,"description" => "Administrateur"],
                ['name' => 'mdp',"description" => "Chef de projet"],
                ['name' => 'commercial',"description" => "Commercial"],
                ['name' => 'dessinator',"description" => "Dessignateur"],
                ['name' => 'client',"description" => "Client"],
                ['name' => 'urba',"description" => "Urbaniste"],
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
