<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvocadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocados', function(Blueprint $table) {

            //Atributos da tabela
            $table->engine = 'InnoDB';

            //Colunas
            $table->increments('id');
            $table->integer('jogador_id')->unsigned();;
            $table->integer('convocatoria_id')->unsigned();;
            $table->boolean('visivel')->default(true);
            $table->timestamps();

            //Chaves estrangeiras
            $table->foreign('jogador_id')->references('id')->on('jogadores');
            $table->foreign('convocatoria_id')->references('id')->on('convocatorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('convocados');
    }
}
