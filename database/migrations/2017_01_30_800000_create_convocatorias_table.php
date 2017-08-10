<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvocatoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocatorias', function(Blueprint $table){

            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('jogo_id')->unsigned();;
            $table->timestamp('data');
            $table->text('local');
            $table->text('descricao');
            $table->boolean('visivel')->default(true);
            $table->timestamps();

            $table->foreign('jogo_id')->references('id')->on('jogos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('convocatorias');
    }
}
