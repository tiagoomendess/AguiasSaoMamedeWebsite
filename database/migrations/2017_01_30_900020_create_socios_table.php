<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {

            //Atributos
            $table->engine = 'InnoDB';

            //Colunas
            $table->increments('id')->unique();
            $table->integer('numero')->unique(); //Numero de sócio
            $table->string('nome');
            $table->string('imagem')->default('storage/avatars/default.png');
            $table->integer('morada_id')->unsigned()->nullable()->references('id')->on('moradas');
            $table->integer('user_id')->unsigned()->nullable()->references('id')->on('users');
            $table->string('cartao_cidadao')->nullable();
            $table->string('email')->nullable();
            $table->string('telemovel')->nullable();
            $table->timestamp('data_inicio');
            $table->timestamp('cotas_ate');
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
        Schema::drop('socios');
    }
}
