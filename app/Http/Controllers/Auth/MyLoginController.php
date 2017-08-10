<?php

namespace App\Http\Controllers\Auth;

use App\SocialProvider;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Lang;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Socialite;
use App\Imagem;
use Carbon\Carbon;

class MyLoginController extends Controller
{
    use ThrottlesLogins; // implementa throttle

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function show(){

        return view('front.login');

    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'email|max:30|min:3|required',
            'password' => 'min:6|required',
            'remember' => 'nullable',
        ]);

        if($validator->fails())
            return redirect('/login')->withErrors($validator)->withInput();

        $dados['email'] = $request->input('email');
        $dados['password'] = $request->input('password');

        if($request->input('remember') != null)
            $dados['remember'] = true;
        else
            $dados['remember'] = false;

        if(Auth::attempt(['email' => $dados['email'], 'password' => $dados['password'], 'verificado' => 1], $dados['remember'])){

            $user = Auth::user();

            //Verificar se está banido do site
            if ($user->isBanned()) {
                User::updateBanInfo($user);
                Auth::logout();
                return back()->withErrors(['auth_banned' => Lang::trans('auth.banned')])->withInput();
            }

            $user->last_login = Carbon::now()->format('Y-m-d H:i:s');
            $user->update();

            //O utilizador foi autenticado
            return redirect('/');
        }else{
            return back()->withErrors(['auth_error' => Lang::trans('auth.failed')])->withInput();
        }
        
    }

    public function logout(Request $request) {

        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Obtain the user information from GitHub.
     *
     *
     */
    public function handleProviderCallback($provider)
    {

        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return redirect('/');
        }

        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
        if(!$socialProvider)
        {

            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user)
            {
                $nomes = explode(" ", $socialUser->getName());

                $user = User::create(['email' => $socialUser->getEmail(),'nome' => $nomes[0], 'apelido' => $nomes[count($nomes) - 1], 'imagem' => $socialUser->getAvatar()]);
            }

            $user->socialProviders()->create(
                ['provider_id' => $socialUser->getId(), 'provider' => $provider]
            );

        }
        else
            $user = $socialProvider->user;

        //Verificar se está banido do site
        if ($user->isBanned()) {
            User::updateBanInfo($user);
            return redirect()->route('LoginPage')->withErrors(['auth_baned' => Lang::trans('auth.banned')])->withInput();
        }

        $user->last_login = Carbon::now()->format('Y-m-d H:i:s');
        auth()->login($user);
        $user->update();
        return redirect('/');
    }

    public function providerExists($provider) {
        $providers = ['facebook', 'google', 'twitter'];

        if ($providers.containsString($provider))
            return true;
        else
            return false;
    }
}
