<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            //Atributos
            $table->engine = 'InnoDB';

            //colunas
            $table->increments('id');
            $table->string('nome');
            $table->string('apelido');
            $table->string('imagem')->default('storage/avatars/default.png');
            $table->string('email')->unique();
            $table->string('password')->default('');
            $table->integer('perm_level')->default(1);
            $table->boolean('verificado')->default(false);
            $table->timestamp('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
