<?php

namespace App\Http\Controllers\Auth;

use App\Mail\EmailConfirmation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Socio;
use App\Jogador;
use App\EmailsPorVerificar;
use Validator;
use Lang;
use Mail;
use Auth;


class MyRegisterController extends Controller
{

    public function __construct(){
        $this->middleware('guest');
    }
    public function show(){
        return view('front.registar');
    }

    public function regista (Request $request) {

        $this->validate($request, [
            'nome' => 'min:2|max:30|required',
            'apelido' => 'min:2|max:30|required',
            'email' => 'email|max:60|unique:users|required',
            'password' => 'min:6|confirmed|max:60|required',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $dados = array('nome', 'apelido', 'email', 'password', 'imagem_id');
        $dados['nome'] = $request->input('nome');
        $dados['apelido'] = $request->input('apelido');
        $dados['email'] = $request->input('email');
        $dados['password'] = bcrypt($request->input('password'));

        //Adicionar id de socio caso ele já seja
        if(Socio::where('email', $dados['email'])->count() == 1){
            $socio = Socio::where('email', $dados['email'])->get();
            $dados['socio_id'] = $socio->id;
        }

        //Adicionar id de jogador caso ele seja
        if(Jogador::where('email', $dados['email'])->count() == 1){
            $jogador = Jogador::where('email', $dados['email'])->get();
            $dados['jogador_id'] = $jogador->id;
        }

        User::create($dados);

        $token = str_random(9);

        EmailsPorVerificar::create(['email' => $dados['email'], 'token' => $token]);

        Mail::to($dados['email'])
            ->send(new EmailConfirmation($dados['nome'], $dados['apelido'], $dados['email'], $token));

        return redirect('/registar/confirmar?email=' . urlencode($dados['email']));

    }

    public function showConfirmarRegisto(Request $request){

        $email = $token = null;

        if ($request->has('email'))
            $email = urldecode($request->input('email'));

        if ($request->has('token'))
            $token = $request->input('token');

        if (($email != null) && ($token != null)) {
            return $this->confirmaEmail($request);
        }

        return view('front.confirmarRegisto')->with(['email' => $email, 'token' => $token]);
    }

    public function confirmaEmail(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|min:3',
            'token' => 'required|min:9',
        ]);

        if($validator->fails())
            return redirect('/registar/confirmar')->withErrors($validator)->withInput();

        $dados['email'] = $request->input('email');
        $dados['token'] = str_replace(' ', '', $request->input('token'));

        //Ir buscar o email a verificar
        $emailPorVerificar = EmailsPorVerificar::where('email', $dados['email'])->first();

        //Significa que não existe
        if($emailPorVerificar == null){
            return redirect('/registar/confirmar')->withErrors(['notConfirmed' => Lang::trans('auth.email_confirmation_failed', ['email' => $dados['email']])])->withInput();
        }

        //Ir buscar o user coorespondente
        $userConfirmado = User::where('email', $dados['email'])->first();

        // Se por alguma razão o email existir na tabela de emails nao verificados
        // mas o user nao existe, return mas antes apaga o email da tabela
        if($userConfirmado == null){
            $emailPorVerificar->delete();
            return redirect('/registar/confirmar')->withErrors(['notConfirmed' => Lang::trans('auth.email_confirmation_failed', ['email' => $dados['email']])])->withInput();
        }

        if ($emailPorVerificar->token == $dados['token']) {

            $userConfirmado->verificado = 1;
            Auth::login($userConfirmado, false);
            $userConfirmado->save();
            $emailPorVerificar->delete();
            return redirect('/');

        }else{

            return redirect('/registar/confirmar')->withErrors(['notConfirmed' => Lang::trans('auth.email_confirmation_failed', ['email' => $dados['email']])])->withInput();
        }

        return;

    }

}

