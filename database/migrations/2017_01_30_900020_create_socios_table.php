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
            $table->integer('numero')->unique()->nullable(); //Numero de sócio
            $table->string('nome');
            $table->string('imagem')->default('default.png');
            $table->integer('morada_id')->unsigned()->nullable()->references('id')->on('moradas');
            $table->integer('user_id')->unsigned()->nullable()->references('id')->on('users');
            $table->string('cartao_cidadao')->nullable();
            $table->string('email')->nullable();
            $table->string('telemovel')->nullable();
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('cotas_ate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('estado')->default(0); //0 é proposta de socio, 1 é socio aceite, 2 é falecido, 3 é eliminado.
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
