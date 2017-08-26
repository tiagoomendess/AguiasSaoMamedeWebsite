<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;


class Socio extends Model
{
    protected $table = 'socios';

    protected $fillable = [
        'nome', 'numero', 'imagem', 'morada_id', 'user_id', 'nif', 'cartao_cidadao', 'email', 'telemovel', 'data_inicio', 'estado'
    ];

    protected function morada(){
        return $this->hasOne('App\Morada');
    }

    protected function cotas(){
        return $this->hasMany('App\Cota');
    }

    public function getCotas() {
        return Cota::where('socio_id', $this->id)->get();
    }

    /**
     * @returns A proxima cota que o socio tem de pagar
    */

    public function proximaCota() {

        //todas as cotas que o socio pagou, pode ser nenhuma
        $cotas = $this->getCotas();

        //Saber qual a proxima cota a pagar
        if ($cotas->count() < 1) {

            $proxima_cota = ListaCotas::where('data_inicio', '<', $this->created_at);
            $proxima_cota = $proxima_cota->where('data_fim', '>', $this->created_at)->first();

        }else {
            $proxima_cota = ListaCotas::find($cotas->last()->cota_id + 1);
        }

        return $proxima_cota;
    }

    protected function user(){
        return $this->hasOne('App\User');
    }

    public static function getStateName($i) {

        switch ($i) {
            case 0:
                return 'Não Aceite';
            case 1:
                return 'Aceite';
            case 2:
                return 'Falecido';
            case 3:
                return 'Eliminado';
            default:
                return 'Unknown';
        }
    }



}