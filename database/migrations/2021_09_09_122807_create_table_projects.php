<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId("client_id");
            $table->foreignId("priority_id")->default(1);
            $table->foreignId("status_id")->default(1);
            $table->decimal("price")->default(0.00);
            $table->enum("estimate" ,['accepted', 'refused'])->nullable();
            $table->integer("validation")->nullable();
            $table->integer("version")->nullable();
            $table->boolean("deleted")->nullable();
            $table->date("start_date")->nullable();
            $table->date("due_date")->nullable();
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
        Schema::dropIfExists('projects');
    }
}
