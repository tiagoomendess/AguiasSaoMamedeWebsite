<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogos', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('visitado_id')->unsigned();;
            $table->integer('visitante_id')->unsigned();;
            $table->timestamp('data');
            $table->integer('competicao_id')->unsigned();;
            $table->string('local');
            $table->boolean('visivel')->default(true);
            $table->timestamps();

            $table->foreign('visitado_id')->references('id')->on('equipas');
            $table->foreign('visitante_id')->references('id')->on('equipas');
            $table->foreign('competicao_id')->references('id')->on('competicoes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jogos');
    }
}
