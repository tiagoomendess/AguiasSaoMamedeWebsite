<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpocasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epocas', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id')->unique;
            $table->integer('ano_inicio');
            $table->integer('ano_fim');
            $table->boolean('visivel')->default(true);
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
        Schema::drop('epocas');
    }
}
