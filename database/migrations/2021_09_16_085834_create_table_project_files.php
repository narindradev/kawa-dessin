<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProjectFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id");
            $table->string("created_by")->nullable();
            $table->boolean("preliminary")->default(0);
            $table->string("url");
            $table->string("src");
            $table->string("name");
            $table->string("originale_name");
            $table->string("type");
            $table->string("size");
            $table->string("extension");
            $table->boolean("deleted")->default(0);
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
        Schema::dropIfExists('project_files');
    }
}
