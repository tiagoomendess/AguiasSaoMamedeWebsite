<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;
use Session;
use DB;
use App\Banned;


class UserController extends Controller
{
    //Pagina de utiliadores no painel
    public function showUtilizadores(Request $request) {

        if ($request->has('procura')) { //Se existir filtro

            $nome = $request->input('nome');
            $email = $request->input('email');

            if ($nome != null && $nome != '') {

                $nomes = explode(' ', $nome);

                $users = DB::table('users')->where('nome', 'like', '%' . $nomes[0] . '%')->orWhere('apelido', 'like', '%' . $nomes[count($nome) - 1] . '%');

                if ($email != null && $email != '') {
                    $users = $users->where('email', $email);
                }
            } else if($email != null &&  $email != '') {
                $users = DB::table('users')->where('email', $email);
            } else {
                $users = DB::table('users');
            }

            $users = $users->paginate(25);
            $admins = User::where('perm_level', '>', 1)->get();

            return view('painel.utilizadores')->with(['admins' => $admins, 'users' => $users, 'email' => $email, 'nome' => $nome]);

        }

        $users = User::paginate(25);

        $admins = User::where('perm_level', '>', 1)->get();


        return view('painel.utilizadores')->with(['admins' => $admins, 'users' => $users]);
    }

    public function edit(User $user)
    {

        return view('painel.editUser')->with(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return
     */
    public function update(Request $request, User $user)
    {

        $rules = array(
            'nome' => 'required|string',
            'apelido' => 'required|string',
            'email' => 'required|email',
            'perm_level' => 'required|numeric',
            'imagem' => 'string|url|required',
        );

        //Vai buscar o user que fez a alteração
        $user2 = Auth::user();

        if ($request->input('perm_level') > Auth::user()->perm_level || Auth::user()->perm_level < $user->perm_level)
            return back()->withInput()->withErrors(['permissions' => 'Nao pode colocar esse utilizador a ' . $user->getRankName($request->input('perm_level'))]);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $user->nome = $request->input('nome');
        $user->apelido = $request->input('apelido');
        $user->email = $request->input('email');
        $user->perm_level = $request->input('perm_level');
        $user->imagem = $request->input('imagem');
        $user->update();

        Session::flash('mensagem-sucesso', 'Utilizador editado com sucesso');

        return back();

    }

    public function ban(Request $request) {

        $this->validate($request, [
            'description' => 'string',
            'user_id' => 'required|numeric',
        ]);

        $user_id = $request->input('user_id');

        $user = User::where('id', $user_id)->first();

        if($user == null) {
            Session::flash('mensagem-erro', 'Utilizador não encontrado!');
            return back();
        }


        if($user->isBanned()) {
            Session::flash('mensagem-erro', 'Esse utilizador já está banido e não consegue entrar no website!');
            return back();
        }

        $dados = [
            'user_id' => $user_id,
            'description' => $request->input('description'),
            'cookie' => time() . $user->id . str_random(16),
        ];

        Banned::create($dados);

        Session::flash('mensagem-sucesso', 'Utilizador ' . $user->nome . ' ' . $user->apelido . ' foi banido com sucesso!');
        return back();
    }

    public function unban(Request $request) {

        $this->validate($request, [
            'user_id' => 'required|numeric',
        ]);

        $user = User::where('id', $request->input('user_id'))->first();

        if ($user == null) {
            Session::flash('mensagem-erro', 'Esse utilizador não existe!');
            return back();
        }

        if (!$user->isBanned()) {
            Session::flash('mensagem-erro', 'Esse utilizador não está banido!');
            return back();
        }

        $banned = Banned::where('user_id', $user->id)->first();

        DB::table('banneds')->where('id', $banned->id)->delete();
        Session::flash('mensagem-sucesso', 'Utilizador ' . $user->nome . ' ' . $user->apelido . ' foi desbanido com sucesso!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Session::flash('mensagem-sucesso', 'Utilizador ' . $user->nome . ' ' . $user->apelido . ' foi apagado com sucesso!');
        DB::table('users')->delete()->where('id', $user->id());
        return back();
    }


}
