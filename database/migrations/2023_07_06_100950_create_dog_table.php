<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('weight');
            $table->integer('age');
            $table->string('image');
            $table->unsignedInteger('race_id');
            $table->unsignedInteger('color_id');
            $table->unsignedInteger('size_id');
            $table->timestamps();

            $table->foreign('race_id')->references('id')->on('race')->onDelete('restrict');
            $table->foreign('color_id')->references('id')->on('color')->onDelete('restrict');
            $table->foreign('size_id')->references('id')->on('size')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
