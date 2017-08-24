<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaCotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_cotas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->default('Cota ' . \Carbon\Carbon::now()->year)->unique();
            $table->timestamp('data_inicio'); //Validade da cota
            $table->timestamp('data_fim');    //Validade da cota
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
        Schema::dropIfExists('lista_cotas');
    }
}
