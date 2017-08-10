<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Jogo extends Model
{

    protected $table = 'jogos';

    protected $fillable = [
        'visitado_id','visitante_id','data','competicao_id','local', 'visivel'
    ];

    public function competicao()
    {
        return $this->belongsTo('App\Competicao');
    }


}