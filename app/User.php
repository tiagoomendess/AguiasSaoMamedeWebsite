<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cookie;
use App\Banned;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'apelido', 'email', 'imagem', 'socio_id', 'jogador_id', 'perm_level', 'password', 'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'verificado'
    ];

    function getRank() {

        return self::getRankName($this->perm_level);
    }

    function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function banned() {
        return $this->hasOne(Banned::class);
    }

    public function isBanned() {


        if (Banned::where('user_id', $this->id)->count() > 0)
            return true;
        else
            return false;

        /*
         * $banned = $this->banned();
         * if ($banned) //se não estiver directamente banido vamos procurar melhor por Ip e cookie
            return false;
        else
            return true;*/

    }

    public static function getRankName($id) {

        switch ($id){
            case 1:
                return 'User';
            case 2:
                return 'Moderator';
            case 3:
                return 'Admin';
            case 4:
                return 'SuperUser';
        }

    }

    public static function updateBanInfo(User $user) {

        if(!$user->isBanned())
            return;

        $banned = $user->banned();
        $cookie = time() . $user->id . str_random(16);

        $ip1 = '';
        if (isset($_SERVER['REMOTE_ADDR']))
            $ip1 = $_SERVER['REMOTE_ADDR'];
        else if(isset($_SERVER['HTTP_CLIENT_IP']))
            $ip1 = $_SERVER['HTTP_CLIENT_IP'];

        $ip2 = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip2 = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ip2 = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ip2 = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ip2 = $_SERVER['HTTP_FORWARDED'];

        $banned->ip_address_1 = $ip1;
        $banned->ip_address_1 = $ip2;
        $banned->cookie = $cookie;

        Cookie::queue(Cookie::make($cookie, ' ', 0));

        return;
    }
}
