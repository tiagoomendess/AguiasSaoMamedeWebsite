<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\ResetPassword;
use App\Mail\EmailResetPassword;
use Validator;
use Lang;
use Mail;
use Auth;

class MyResetPasswordController extends Controller
{
    public function show() {

        return view('front.resetPassword');
    }

    //Chamado quando e feito o post do from de pedir reset
    public function resetPassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'email|max:30|min:3|required',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'g-recaptcha-response.required' => Lang::trans('validation.custom.g-recaptcha-response.required'),
            'g-recaptcha-response.captcha' => Lang::trans('validation.custom.g-recaptcha-response.captcha'),
        ]);

        if($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $infos = array('password_sent' => Lang::trans('auth.reset_password_sent', ['email' => $request->input('email')]));

        //Ir buscar o user coorespondente
        $user = User::where('email', $request->input('email'))->first();

        if ($user == null)
            return view('front.resetPassword')->with(['infos' => $infos]);

        $token = str_random(32);
        $resetPassModel = ResetPassword::where('email', $request->input('email'))->first();

        if($resetPassModel == null){
            $resetPassModel = ResetPassword::create(['email' => $request->input('email'), 'token' => $token]);
        }
        else {
            $resetPassModel->token = $token;
        }

        $resetPassModel->save();

        Mail::to($user->email)
            ->send(new EmailResetPassword($user->nome, $user->apelido, $user->email, $token));

        return view('front.resetPassword')->with(['infos' => $infos]);

    }

    public function showChangePassword($token) {

        return view('front.changePassword')->with(['token' => $token]);

    }

    public function changePassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'password' => 'min:6|confirmed|max:60|required',
            'g-recaptcha-response' => 'required|captcha',
            'token' => 'string|required'
        ], [
            'g-recaptcha-response.required' => Lang::trans('validation.custom.g-recaptcha-response.required'),
            'g-recaptcha-response.captcha' => Lang::trans('validation.custom.g-recaptcha-response.captcha'),
        ]);

        $token = $request->input('token');

        if($validator->fails())
            return redirect()->back()->withErrors($validator);

        $resetPasswordRequest = ResetPassword::where('token', $token)->first();

        if ($resetPasswordRequest == null)
            redirect()->route('showChangePassword')->withErrors(Lang::trans('auth.password_not_changed'));

        $user = User::where('email', $resetPasswordRequest->email)->first();
        if ($user == null)
            redirect()->route('showChangePassword')->withErrors(Lang::trans('auth.password_not_changed'));

        $user->password = bcrypt($request->input('password'));
        $user->save();
        //Enviar email a avisar que a password foi mudada
        //Not implemented yet
        $resetPasswordRequest->delete();

        //autenticar o utilizador
        Auth::login($user);

        return redirect()->route('index')->with(['infos' => Lang::trans('auth.password_changed')]);
    }
}
