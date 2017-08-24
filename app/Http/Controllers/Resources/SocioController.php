<?php

namespace App\Http\Controllers\Resources;

use App\Socio;
use Carbon\Carbon;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Morada;
use Image;
use App\User;
use DB;
use Session;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    //Pagina de utiliadores no painel
    public function showSocios(Request $request) {

        if ($request->has('procura')) { //Se existir filtro

            $nome = $request->input('nome');
            $numero = $request->input('numero');

            if ($nome != null && $nome != '') {

                $socios = DB::table('socios')->where('nome', 'like', '%' . $nome . '%');

                if ($numero != null && $numero != 0) {
                    $socios = $socios->where('numero', $numero);
                }
            } else if($numero != null && $numero != 0) {
                $socios = DB::table('socios')->where('numero', $numero);
            } else {
                $socios = DB::table('socios');
            }

            $socios = $socios->paginate(25);
            $propostas = Socio::where('estado', 0)->get();

            return view('painel.socios')->with(['propostas' => $propostas, 'socios' => $socios, 'numero' => $numero, 'nome' => $nome]);

        }

        $socios = Socio::where('estado', '!=', 0);
        $socios = $socios->paginate(25);

        $propostas = Socio::where('estado', 0)->get();


        return view('painel.socios')->with(['socios' => $socios, 'propostas' => $propostas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        $ultimo_socio = Socio::where('visivel', true)->orderBy('numero', 'desc')->take(1)->first();

        if ($ultimo_socio == null)
            $proximoNumero = 1;
        else
            $proximoNumero = $ultimo_socio->numero + 1;

        return view('Painel.createSocio')->with(['proximoNumero' => $proximoNumero]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'numero' => 'required|numeric|unique:socios,numero',
            'nome' => 'required|string|min:10|max:100',
            'cc' => 'nullable|numeric',
            'email' => 'nullable|email|min:5|max:50',
            'telemovel' => 'nullable|string|min:9|max:20',
            'data_inicio' => 'required|date',
            'fotografia' => 'nullable|image|max:10000',
            'rua' => 'required|string|min:4|max:30',
            'numero_porta' => 'required|numeric',
            'codigo_postal' => 'required|string',
            'localidade' => 'required|string|min:2|max:30',
            'cidade' => 'required|string|min:2|max:30',
            'pais' => 'required|string|min:2|max:30',
        ]);

        $numero_socio = $request->input('numero');
        $nome = $request->input('nome');
        $cc = $request->input('cc');
        $email = $request->input('email');
        $telemovel = $request->input('telemovel');
        $data_inicio = $request->input('data_inicio');
        $cotas_ate = Carbon::createFromTime(0,0);

        //Foto
        if ($request->hasFile('fotografia')) {

            $fotografia = $request->file('fotografia');
            $clientFileName = $fotografia->getClientOriginalName();
            $clientFileName = str_replace('.jpg', '', $clientFileName);
            $clientFileName = str_replace('.png', '', $clientFileName);
            $filename = $clientFileName . time() . str_random(4) . '.' . $fotografia->getClientOriginalExtension();
            $img = Image::make($fotografia);
            $img->fit(400);
            $img->save( public_path('storage/uploads/avatars/socios/') . $filename);

        } else {
            $filename = 'default.png';
        }

        $rua = $request->input('rua');
        $numero_porta = $request->input('numero_porta');
        $codigo_postal = $request->input('codigo_postal');
        $localidade = $request->input('localidade');
        $cidade = $request->input('cidade');
        $pais = $request->input('pais');

        $telemovel = str_replace(' ', '', $telemovel);
        $cc = str_replace(' ', '', $cc);

        //Verificar se o email já está registado
        if (DB::table('users')->where('email', $email)->count() == 1) {

            $user_socio = User::where('email', $email)->first();
            $user_id = $user_socio->id;
        }
        else {
            $user_id = null;
        }

        $morada = Morada::create([
            'rua' => $rua,
            'numero' => $numero_porta,
            'codigo_postal' => $codigo_postal,
            'localidade' => $localidade,
            'cidade' => $cidade,
            'pais' => $pais,
        ]);

        $socio = Socio::create([
            'numero' => $numero_socio,
            'nome' => $nome,
            'imagem' => $filename,
            'morada_id' => $morada->id,
            'user_id' => $user_id,
            'cartao_cidadao' => $cc,
            'email' => $email,
            'telemovel' => $telemovel,
            'data_inicio' => $data_inicio,
            'cotas_ate' => $cotas_ate->toDateString(),
            'visivel' => true,
            'estado' => 1,
        ]);

        return redirect(route('showSocio', $socio));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return
     */
    public function show(Socio $socio)
    {
        $morada = Morada::find($socio->morada_id);
        return view('painel.showSocio')->with(['socio' => $socio, 'morada' => $morada]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit(Socio $socio)
    {
        $morada = Morada::find($socio->morada_id);

        if ($socio->user_id == null)
            $user = null;
        else
            $user = User::findOrFail($socio->user_id);

        return view('painel.editSocio', ['socio' => $socio, 'morada' => $morada, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return
     */
    public function update(Request $request, Socio $socio)
    {

        $this->validate($request, [
            'numero' => 'required|numeric',
            'nome' => 'required|string|min:10|max:100',
            'cc' => 'nullable|numeric',
            'email' => 'nullable|email|min:5|max:50',
            'telemovel' => 'nullable|string|min:9|max:20',
            'data_inicio' => 'required|date',
            'fotografia' => 'nullable|image|max:10000',
            'rua' => 'required|string|min:4|max:30',
            'numero_porta' => 'required|numeric',
            'codigo_postal' => 'required|string',
            'localidade' => 'required|string|min:2|max:30',
            'cidade' => 'required|string|min:2|max:30',
            'pais' => 'required|string|min:2|max:30',
            'estado' => 'numeric|required',
        ]);

        $morada = Morada::find($socio->morada_id);
        if ($socio->user_id != null)
            $user = User::find($socio->user_id);
        else
            $user = null;

        if ($request->has('default_image')) {
            $socio->imagem = 'default.png';
        }

        $numero_socio = $request->input('numero');
        $nome = $request->input('nome');
        $cc = $request->input('cartao_cidadao');
        $email = $request->input('email');
        $telemovel = $request->input('telemovel');
        $data_inicio = $request->input('data_inicio');
        $estado = $request->input('estado');

        //Foto
        if ($request->hasFile('fotografia')) {

            $fotografia = $request->file('fotografia');
            $clientFileName = $fotografia->getClientOriginalName();
            $clientFileName = str_replace('.jpg', '', $clientFileName);
            $clientFileName = str_replace('.png', '', $clientFileName);
            $filename = $clientFileName . time() . str_random(4) . '.' . $fotografia->getClientOriginalExtension();
            $img = Image::make($fotografia);
            $img->fit(400);
            $img->save( public_path('storage/uploads/avatars/socios/') . $filename);
            $socio->imagem = $filename;

        }

        $rua = $request->input('rua');
        $numero_porta = $request->input('numero_porta');
        $codigo_postal = $request->input('codigo_postal');
        $localidade = $request->input('localidade');
        $cidade = $request->input('cidade');
        $pais = $request->input('pais');

        $telemovel = str_replace(' ', '', $telemovel);
        $cc = str_replace(' ', '', $cc);

        //editar socio
        if ($socio->numero != $numero_socio)
        {
            if (Socio::where('numero', $numero_socio)->count() < 1)
                $socio->numero = $numero_socio;
            else
                Session::flash('mensagem-erro', 'Não foi possível alterar o número de sócio porque já existe um outro sócio com esse número.');

        }

        //Handle email
        if ($socio->email != $email) {

            if (Socio::where('email', $email)->count() > 0)
            {
                Session::flash('mensagem-erro', 'Não foi possível alterar o email de sócio porque já existe um outro sócio com esse mesmo email.');
                return back();
            }

            //Verificar se o email já está registado
            if (DB::table('users')->where('email', $email)->count() == 1) {

                $user_socio = User::where('email', $email)->first();
                $user_id = $user_socio->id;
            }
            else {
                $user_id = null;
            }

            $socio->user_id = $user_id;

        }

        $socio->nome = $nome;
        $socio->cartao_cidadao = $cc;
        $socio->email = $email;
        $socio->telemovel = $telemovel;
        $socio->data_inicio = $data_inicio;
        $socio->estado = $estado;
        $socio->save();

        $morada->rua = $rua;
        $morada->numero = $numero_porta;
        $morada->codigo_postal = $codigo_postal;
        $morada->localidade = $localidade;
        $morada->cidade = $cidade;
        $morada->pais = $pais;
        $morada->save();

        return redirect(route('showSocio', $socio));
    }

    /**
     * It does not really delete anything lol
     * */
    public function destroy(Socio $socio)
    {
        //"Eliminar o sócio"
        $socio->estado = 3;
        $socio->numero = null;
        $socio->save();

        //Mensagem de sucesso
        Session::flash('mensagem-sucesso', 'Sócio eliminado com sucesso!');
        return redirect(route('socios'));
    }
}
