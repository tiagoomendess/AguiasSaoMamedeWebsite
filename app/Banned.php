<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banned extends Model
{
    protected $fillable = ['user_id', 'ip_address_1', 'ip_address_2', 'cookie', 'description'];

    public function getUser() {
        return User::where('id', $this->user_id)->get();
    }

    public function user() {
        return $this->hasOne('App\User');
    }
}
