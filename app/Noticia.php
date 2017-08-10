<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Noticia extends Model
{
    use Sluggable;

    protected $table = 'noticias';

    protected $fillable = [
        'titulo', 'corpo', 'imagem', 'data', 'visivel'
    ];

    public function sluggable() {
        return [
            'slug' => [
                'source'         => 'titulo',
                'separator'      => '-',
                'includeTrashed' => true,
            ]
        ];
    }


}

