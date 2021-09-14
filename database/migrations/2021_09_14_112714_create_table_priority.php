<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePriority extends Migration
{
    private $table = "priority";
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
            $table->string("name");
            $table->string("color")->nullable();
            $table->string("class")->nullable();
        });
        $this->seed();
    }
    private function seed(){
        DB::table($this->table)->insert([
                ['name' => 'normale', 'color' =>"" ,"class" => "info"],
                ['name' => 'medium', 'color' =>"" ,"class" => "warining"],
                ['name' => 'hight', 'color' =>"" ,"class" => "danger"],
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
