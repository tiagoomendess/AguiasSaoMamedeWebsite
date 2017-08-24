<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaCotas extends Model
{
    protected $fillable = ['nome', 'data_inicio', 'data_fim'];
}
