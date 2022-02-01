<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProjectRelanuchs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_relaunchs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id");
            $table->foreignId("relaunch_id")->nullable();
            $table->string("seen_by")->nullable()->default("0");
            $table->string("files")->nullable();
            $table->bigInteger("created_by")->nullable();
            $table->longText("note")->nullable();
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
        Schema::dropIfExists('project_relaunchs');
    }
}
