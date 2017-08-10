<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paginas', function(Blueprint $table) {

            //Atributos
            $table->engine = 'InnoDB';

            //Colunas
            $table->increments('id');
            $table->string('titulo');
            $table->string('slug');
            $table->text('conteudo');
            $table->integer('pocisao_menu'); //Quanto mais pequeno aparece primeiro
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
        //
    }
}
