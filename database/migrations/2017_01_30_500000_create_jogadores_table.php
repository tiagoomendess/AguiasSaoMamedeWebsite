<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogadores', function (Blueprint $table) {

            //Atributos
            $table->engine = 'InnoDB';

            //Colunas
            $table->increments('id')->unique();
            $table->string('nome');
            $table->string('imagem');
            $table->integer('numero')->unique();
            $table->timestamp('data_nascimento');
            $table->string('telemovel');
            $table->string('email');
            $table->string('posicao');
            $table->string('slug');
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
        Schema::drop('jogadores');
    }
}
