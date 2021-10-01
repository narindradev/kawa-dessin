<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->string('users')->nullable();
            $table->string('last_assigned')->nullable();
        });

        $this->seed();
    }

    function seed(){
        DB::table('project_assignments')->insert(
            array(
                ['user_type' => 'Commercial'],
                ['user_type' => 'Chef de projet'],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_assignments');
    }
}
