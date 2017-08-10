<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Jogador extends Model
{
    use Sluggable;

    protected $table = 'jogadores';

    protected $fillable = [
        'nome', 'numero', 'imagem', 'data_nascimento', 'telemovel', 'email', 'posicao', 'visivel'
    ];

    public function sluggable() {
        return [
            'slug' => [
                'source'         => 'nome',
                'separator'      => '-',
                'includeTrashed' => true,
            ]
        ];
    }



}

