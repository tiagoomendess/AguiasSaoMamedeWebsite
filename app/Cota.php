<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cota extends Model
{
    protected $fillable = ['cota_id', 'socio_id', 'pagamento_id', 'data'];
}
