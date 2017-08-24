@extends('painel.layouts.default-page')

@section('page_title')
    Editar sócio número {{ $socio->numero }}
@endsection

@section('page_content')

    @include('painel.parcial.message')

    <div class="row">

        <div class="col l5 m12 s12">
            <div class="caixa-delimitadora-fina">

                <table>
                    <tr>
                        <td style="width: 50%">
                            {{ Html::image('storage/uploads/avatars/socios/' . $socio->imagem, 'Imagem de perfil de ' . $socio->nome, ['style' => 'width:100%']) }}
                        </td>
                        <td>
                            <p>
                                <b>Criado em:</b> <br> {{ $socio->created_at }} <br>
                                <b>Actualizado em:</b> <br> {{ $socio->updated_at }} <br>
                                <b>Registado:</b> @if($user==null) Não @else <a href="{{ route('editUtilizador', $user) }}">Sim</a>@endif
                            </p>
                        </td>
                    </tr>
                </table>

            </div>


        </div>


        <div class="col l7 m12 s12">

            <div class="caixa-delimitadora-fina">

                <div class="row">
                    <div class="col l12">
                        @include('parcial.errors', ['errors' => $errors])
                    </div>
                </div>


                <form enctype="multipart/form-data" method="POST" action="{{ route('updateSocio', ['socio' => $socio, 'morada' => $morada, 'user' => $user]) }}">

                    <div class="row">
                        <div class="input-field col s9 m9 l9">
                            <input name="nome" id="nome" type="text" class="validate" value="{{ old('nome', $socio->nome)}}" required>
                            <label for="nome">@lang('auth.form_name')</label>
                        </div>

                        <div class="input-field col s3 m3 l3">
                            <input name="numero" id="numero" type="text" class="validate" value="{{ old('numero', $socio->numero)}}" required>
                            <label for="numero">Número</label>
                        </div>

                        <div class="file-field input-field col s12">
                            <div class="btn orange">
                                <span>Alterar Fotografia</span>
                                <input type="file" name="fotografia" accept="image/*" id="capture" capture="camera">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" value="{{ $socio->imagem }}">
                            </div>

                            @if($socio->imagem != 'default.png')
                                <div>
                                    <input name="default_image" type="checkbox" id="default_image" />
                                    <label for="default_image">Atribuir imagem de defeito</label>
                                </div>
                            @endif

                        </div>

                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="email" id="email" type="email" class="validate" value="{{ old('email', $socio->email)}}" required>
                            <label for="email">@lang('auth.form_email')</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="telemovel" id="telemovel" type="text" class="validate" value="{{ old('telemovel', $socio->telemovel)}}" required>
                            <label for="telemovel">Telemovel</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="cartao_cidadao" id="cartao_cidadao" type="text" class="validate" value="{{ old('cartao_cidadao', $socio->cartao_cidadao)}}" required>
                            <label for="cartao_cidadao">Cartão de Cidadão</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="data_inicio" name="data_inicio" type="text" class="datepicker" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                            <label for="data_inicio">Sócio desde</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s6">
                            <p style="color: gray; font-size: 13px;">Estado</p>
                            <select name="estado" class="browser-default">
                                @for($i = 0; $i < 3; $i++)
                                    <option value="{{ $i }}" @if($socio->estado == $i) selected @endif>{{ \App\Socio::getStateName($i) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s9">
                            <input name="rua" id="rua" type="text" class="validate" value="{{old('rua', $morada->rua)}}">
                            <label for="rua">Rua</label>
                        </div>

                        <div class="input-field col s3">
                            <input name="numero_porta" id="numero_porta" type="number" class="validate" value="{{old('numero_porta', $morada->numero)}}">
                            <label for="numero_porta">Número</label>
                        </div>
                    </div>

                    <div class="row">

                        <div class="input-field col s6 m6 l3">
                            <input name="codigo_postal" id="codigo_postal" type="text" class="validate" value="{{old('codigo_postal', $morada->codigo_postal)}}">
                            <label for="codigo_postal">Código Postal</label>
                        </div>

                        <div class="input-field col s6 m6 l3">
                            <input name="localidade" id="localidade" type="text" class="validate" value="{{old('localidade', $morada->localidade)}}">
                            <label for="localidade">Freguesia</label>
                        </div>

                        <div class="input-field col s12 m6 l3">
                            <input name="cidade" id="cidade" type="text" class="validate" value="{{old('cidade', $morada->cidade)}}">
                            <label for="cidade">Cidade</label>
                        </div>

                        <div class="input-field col s12 m6 l3">
                            <select class="browser-default" name="pais">
                                <option value="{{ $morada->pais }}" selected>{{ $morada->pais }}</option>
                                <option value="Portugal">Portugal</option>
                                <option value="França">França</option>
                                <option value="Espanha">Espanha</option>
                                <option value="Inglaterra">Inglaterra</option>
                                <option value="Italia">Italia</option>
                                <option value="Angola">Angola</option>
                                <option value="Moçambique">Moçambique</option>
                            </select>
                        </div>

                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="row">
                        <div class="input-field col s12 m12 l12 center">
                            <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('forms.guardar')
                                <i class="material-icons right">save</i>
                            </button>

                            <a href="{{ route('showSocio', $socio) }}" class="white-text-btn waves-effect waves-light btn light-blue">CANCELAR <i class="material-icons right">cancel</i></a>

                        </div>


                    </div>


                    {{ csrf_field() }}

                </form>
            </div>
        </div>


    </div>
    </div>

@endsection

@section ('after-scripts')
    <script>
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year,
            format: 'yyyy-mm-dd',
            today: 'Hoje',
            clear: 'Limpar',
            close: 'Ok',
            closeOnSelect: false // Close upon selecting a date,
        });
    </script>
@endsection