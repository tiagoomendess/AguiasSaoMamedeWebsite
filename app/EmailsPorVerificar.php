<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailsPorVerificar extends Model
{
    protected $table = 'emails_por_verificar';
    protected $fillable = ['email', 'token'];
}
