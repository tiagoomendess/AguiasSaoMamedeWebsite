<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


//Rotas do painel de administração
Route::group(['prefix' => 'painel', 'middleware' => 'admin'], function () {

    App::setLocale('pt');
    $user = Auth::getUser();

    Route::get('/', function () {
        return view('painel.inicio');
    })->name('painel');

    Route::get('/socio/{socio}/show', 'Resources\SocioController@show')->name('showSocio');
    Route::get('/socios', 'Resources\SocioController@showSocios')->name('socios');
    Route::post('/socios', 'Resources\SocioController@showSocios')->name('socios'); //para procurar nomes especificos
    Route::get('/socios/atrasados', 'Resources\SocioController@sociosAtrasados')->name('sociosAtrasados');
    Route::get('/socio/create', 'Resources\SocioController@create')->name('createSocio');
    Route::post('/socio/store', 'Resources\SocioController@store')->name('storeSocio');
    Route::get('/socio/{socio}/edit', 'Resources\SocioController@edit')->name('editSocio');
    Route::post('/socio/{socio}/update', 'Resources\SocioController@update')->name('updateSocio');
    Route::get('/socio/{socio}/destroy', 'Resources\SocioController@destroy')->name('destroySocio');

    Route::get('/utilizadores', 'Resources\UserController@showUtilizadores')->name('showUtilizadores');
    Route::post('/utilizadores', 'Resources\UserController@showUtilizadores')->name('showUtilizadoresProcura');
    Route::get('/utilizador/{user}/edit', 'Resources\UserController@edit')->name('editUtilizador');
    Route::post('/utilizador/{user}/update', 'Resources\UserController@update')->name('updateUtilizador');
    Route::get('/utilizador/{user}/destroy', 'Resources\UserController@destroy')->name('destroyUtilizador');
    Route::post('/utilizador/ban', 'Resources\UserController@ban')->name('banUser');
    Route::post('/utilizador/unban', 'Resources\UserController@unban')->name('unbanUser');

    Route::get('/definicoes', 'Resources\UserController@showUtilizadores')->name('showDefinicoes');

});
//Fim das rotas do painel de administração

Route::get('/', ['as' => 'index', 'uses' => 'Front\IndexController@index']);

//Rotas sobre autenticação

Route::get('/registar', 'Auth\MyRegisterController@show')->name('RegisterPage');
Route::post('/registar', 'Auth\MyRegisterController@regista')->name('Register');
Route::get('/registar/confirmar', 'Auth\MyRegisterController@showConfirmarRegisto')->name('ConfirmEmailPage');
Route::post('/registar/confirmar', 'Auth\MyRegisterController@confirmaEmail')->name('ConfirmEmail');
Route::get('/login', 'Auth\MyLoginController@show')->name('LoginPage');
Route::get('/login/social/{provider}', 'Auth\MyLoginController@redirectToProvider');
Route::get('/login/social/{provider}/callback', 'Auth\MyLoginController@handleProviderCallback');
Route::get('/logout', 'Auth\MyLoginController@logout')->name('Logout');
Route::post('/login', 'Auth\MyLoginController@login')->name('Login');
Route::get('/password/reset', 'Auth\MyResetPasswordController@show')->name('ResetPasswordPage');
Route::post('/password/reset', 'Auth\MyResetPasswordController@resetPassword')->name('ResetPassword');
Route::get('/password/change/{token}', 'Auth\MyResetPasswordController@showChangePassword')->name('ChangePasswordPage');
Route::post('/password/change', 'Auth\MyResetPasswordController@changePassword')->name('ChangePassword');



//Fim das rotas de autenticação


/* TESTES */
Route::get('/email', function(){
    return view('emails.email-confirmation')->with([
        'assunto' => 'Isto e um assunto',
        'html_body' => 'Isto é o corpo da mensagem',
        'html_footer' => '<p>Isto é o rodape</p>'
    ]);
});
