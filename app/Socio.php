<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;


class Socio extends Model
{
    protected $table = 'socios';

    protected $fillable = [
        'nome', 'numero', 'imagem', 'morada_id', 'user_id', 'nif', 'cartao_cidadao', 'email', 'telemovel', 'cotas_ate', 'data_inicio', 'estado'
    ];

    protected function morada(){
        return $this->hasOne('App\Morada');
    }

    protected function user(){
        return $this->hasOne('App\User');
    }

    public static function getStateName($i) {

        switch ($i) {
            case 0:
                return 'Não Aceite';
            case 1:
                return 'Aceite';
            case 2:
                return 'Falecido';
            case 3:
                return 'Eliminado';
            default:
                return 'Unknown';
        }
    }

}