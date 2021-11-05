<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvoiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("invoice_id");
            $table->foreignId("project_id")->nullable();
            $table->foreignId("client_id");
            $table->string("status")->nullable();
            $table->longText("payment_data")->nullable();
            $table->integer("slice")->nullable();
            $table->string("pdf")->nullable();
            $table->date("due_date")->nullable();
            $table->bigInteger("amount")->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
}
