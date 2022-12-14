<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreign('user_id')->references('id')->on('Users')->onDelete('cascade');
            $table->foreignId("subject_id");
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->string("title");
            $table->text('description');
            $table->tinyInteger('status')->default(1);
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
