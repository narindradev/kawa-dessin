<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStatus extends Migration
{

    private $table = "status";
  
    public function up()
    {
      
        $this->down();
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("color")->nullable();
            $table->string("class")->default("primary");
            $table->timestamps();
        });
        $this->seed();
    }
    private function seed(){
        DB::table($this->table)->insert([
                ['name' => 'new', 'color' =>"" ,"class" => "danger"],
                ['name' => 'reiceive', 'color' =>"" ,"class" => "light"],
                ['name' => 'estimated', 'color' =>"" ,"class" => "danger"],
                ['name' => 'started', 'color' =>"" ,"class" => "primary"],
                ['name' => 'in_progress', 'color' =>"" ,"class" => "info"],
                ['name' => 'stand_by', 'color' =>"" ,"class" => "dark"],
                ['name' => 'to_do', 'color' =>"" ,"class" => "warning"],
                ['name' => 'finish', 'color' =>"" ,"class" => "success"],
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
