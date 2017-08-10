<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;


class Competicao extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'competicoes';

    protected $fillable = [
        'titulo', 'epoca_id', 'visivel'
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

    public function epoca()
    {
        return $this->belongsTo('App\Epoca');
    }

    public function competicao()
    {
        return $this->hasMany('App\Jogo');
    }



}