<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['level', 'date', 'description'];

    public static function info($description) {

        Log::create([
            'level' => 1,
            'description' => $description,
        ]);

        return;
    }

    public static function warning($description) {

        Log::create([
            'level' => 2,
            'description' => $description,
        ]);

        return;
    }

    public static function error($description) {

        Log::create([
            'level' => 3,
            'description' => $description,
        ]);

        return;
    }
}
