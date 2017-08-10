<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Morada extends Model
{
    protected $fillable = ['rua', 'numero', 'codigo_postal', 'localidade', 'cidade', 'pais'];
}
