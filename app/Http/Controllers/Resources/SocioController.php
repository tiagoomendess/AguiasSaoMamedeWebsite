<?php

namespace App\Http\Controllers\Resources;

use App\Socio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Morada;
use Image;
use App\User;
use DB;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Painel.createSocio');
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
        //Foto
        if ($request->hasFile('fotografia')) {
            $fotografia = $request->file('fotografia');
            $filename = $fotografia->getFilename() . time() . str_random(4) . '.' . $fotografia->getClientOriginalExtension();
            $img = Image::make($fotografia);
            $img->fit(400);
            $img->save( public_path('storage/uploads/avatars/socios/') . $filename);
            dd('Tem imagem');

        } else {
            dd('Default Foto');
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
            'cotas_ate' => DB::raw('CURRENT_TIMESTAMP'),
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
        return view('painel.showSocio')->with(['socio' => $socio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit(Socio $socio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Socio $socio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        //
    }
}
