<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {

            //Atributos
            $table->engine = 'InnoDB';

            //Colunas
            $table->increments('id');
            $table->text('titulo');
            $table->text('corpo');
            $table->string('imagem');
            $table->timestamp('data');
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
        Schema::drop('noticias');
    }
}
