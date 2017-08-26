<?php

namespace App\Http\Controllers\Resources;

use App\Cota;
use App\ListaCotas;
use App\Payment;
use App\Socio;
use Carbon\Carbon;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Morada;
use Image;
use App\User;
use DB;
use Session;
use App\Log;
use Auth;

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

            $socios = $socios->where('estado', 1)->orWhere('estado', 2);
            $socios = $socios->paginate(25);
            $propostas = Socio::where('estado', 0)->get();

            return view('painel.socios')->with(['propostas' => $propostas, 'socios' => $socios, 'numero' => $numero, 'nome' => $nome]);

        }

        $socios = Socio::where('estado', 1)->orWhere('estado', 2);
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
        $ultimo_socio = Socio::where('estado', 1)->orWhere('estado', 2)->orderBy('numero', 'desc')->take(1)->first();

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
            'data_inicio' => 'date|nullable',
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
            'visivel' => true,
            'estado' => 0,
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
        if ($socio->estado == 3)
            abort(404);

        $cotas = $socio->getCotas();

        //Saber qual a proxima cota a pagar
        $proxima_cota = $socio->proximaCota();

        $morada = Morada::find($socio->morada_id);
        return view('painel.showSocio')->with(['socio' => $socio, 'morada' => $morada, 'cotas' => $cotas, 'proxima_cota' => $proxima_cota]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit(Socio $socio)
    {
        if ($socio->estado == 3)
            abort(404);

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
            else {
                Session::flash('mensagem-erro', 'Não foi possível alterar o número de sócio porque já existe um outro sócio com esse número.');
                return back();
            }

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

    public function pagarCota(Request $request, Socio $socio) {

        $this->validate($request, [
            'cota_id' => 'numeric|required',
            'data' => 'date|required',
            'montante' => 'numeric|required',
        ]);

        $cota_id = $request->input('cota_id');
        $data = $request->input('data');
        $montante = $request->input('montante');

        $proxima_cota = $socio->proximaCota();

        //verificar se a cota é valida
        if ($proxima_cota->id != $cota_id) {
            Session::flash('mensagem-erro', 'Cota invalida.');
        }

        $user = Auth::user();

        $cota = ListaCotas::find($cota_id);
        if ($cota == null) {
            Session::flash('mensagem-erro', 'Cota invalida.');
            return back();
        }

        //cotas que o socio ja pagou, pode ser 0
        $cotasSocio = $socio->getCotas();

        //fazer o pagamento
        $pagamento = Payment::make('cash', 'Pagamento de cota do socio numero ' . $socio->numero, $montante);


        //Avisar caso o pagamento
        if ($montante <= 0.0)
            Log::warning('Foi feito um pagamento de cotas com o montante de ' . $montante .' Euros!');

        $cotaPaga = Cota::create([
            'cota_id' => $cota_id,
            'socio_id' => $socio->id,
            'pagamento_id' => $pagamento->id,
            'data' => $data,
        ]);

        if($socio->estado == 0) {
            $socio->estado = 1;
            $socio->save();
        }

        Log::info($user->nome . ' ' . $user->apelido . ' (' . $user->id . ') marcou a ' . $cota->nome . ' como paga ao socio numero ' . $socio->numero);

        Session::flash('mensagem-sucesso', 'Cota atualizada com sucesso');
        return redirect()->back();

    }

    /**
     * Remove a ultima cota do socio
    */
    public function removerCota(Request $request, Socio $socio) {

        $cotas = $socio->getCotas();
        $user = Auth::user();

        if ($cotas->count() < 1) {
            Session::flash('mensagem-erro', 'Não existe nenhuma cota para remover.');
            back();
        }

        $cotaApagar = $cotas->last();
        $nomeCota = $cotaApagar->nome;

        Log::info($user->nome . ' ' . $user->apelido . ' (' . $user->id . ') eliminou a ' . $nomeCota . ' ao socio número ' . $socio->numero);

        $pagamento = Payment::find($cotaApagar->pagamento_id);
        $cotaApagar->delete();
        $pagamento->deleted = true;
        $pagamento->save();

        Session::flash('mensagem-sucesso', 'Cota removida com sucesso');
        return redirect()->back();
    }


    /**
     * Mostra todos os socios com cotas em atraso
    */
    public function sociosAtrasados(Request $request) {

        $socios = Socio::where('estado', 1)->paginate(15);
        $sociosAtrasados = new Collection();

        foreach ($socios as $socio) {

            $cotas = $socio->getCotas();

            if ($cotas->count() == 0) {
                $sociosAtrasados->add($socio);
            } else {
                if (Carbon::parse(ListaCotas::find($cotas->last()->cota_id)->data_fim)->year < Carbon::now()->year) {
                    $sociosAtrasados->add($socio);
                }
            }
        }

        return view('painel.sociosAtrasados', ['socios' => $sociosAtrasados]);
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
