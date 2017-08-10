<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Equipa extends Model
{
    use Sluggable;

    protected $table = 'equipas';

    protected $fillable = [
        'nome', 'emblema', 'visivel'
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