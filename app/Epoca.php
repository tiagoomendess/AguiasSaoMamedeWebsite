<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Epoca extends Model implements SluggableInterface
{

    protected $table = 'epocas';

    protected $fillable = [
        'ano_inicio', 'ano_fim', 'visivel'
    ];

    public function competicoes()
    {
        return $this->hasMany('App\Competicoes');
    }

}