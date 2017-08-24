@extends('painel.layouts.default-page')

@section('page_title')
    @lang('menu.socios')
@endsection

@section('page_content')

    @include('painel.parcial.message')


    <div class="row">

        <div class="col l8 m12 s12">

            <div class="caixa-delimitadora-fina">
                <h5>Pesquisar Sócios</h5>
                <div class="divider"></div>
                <p>Preencha pelo menos um campo que sabe.</p>
                <form method="POST" action="{{ route('socios') }}">
                    <div class="row">

                        {{ csrf_field() }}

                        <input type="hidden" name="procura" value="true">

                        <div class="input-field col s12 m12 l12">
                            <input name="nome" id="nome" type="text" class="validate" value="@if (isset($nome)){{ $nome }}@endif">
                            <label for="nome">@lang('auth.form_name')</label>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <input name="numero" id="numero" type="number" class="validate" value="@if (isset($numero)){{ $numero }}@endif">
                            <label for="numero">@lang('forms.numero_socio')</label>
                        </div>

                        <div class="col s6 m6 l6">
                            <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('forms.procurar')
                                <i class="material-icons right">send</i>
                            </button>
                        </div>

                        @if(isset($nome) || isset($numero))
                            <div class="col s6 m6 l6">
                                <a href="{{ route('socios') }}" class="right waves-effect waves-light btn red"><i class="material-icons left">close</i>Apagar filtro</a>
                            </div>
                        @endif

                    </div>
                </form>
            </div>

            <div class="caixa-delimitadora-fina">

                @if(isset($numero) || isset($nome))
                    <h5>Resultado da Pesquisa <small>({{ $socios->count() }})</small> </h5>
                @else
                    <h5>Todos os Sócios <small>({{ $socios->count() }})</small></h5>
                @endif

                <div class="divider"></div>

                <ul class="collection">

                    @foreach ($socios as $socio)

                        <li class="collection-item avatar">

                            {{ Html::image('storage/uploads/avatars/socios/' . $socio->imagem, 'Imagem de perfil de ' . $socio->nome, ['class' => 'circle']) }}
                            <span class="title"><b>{{ $socio->nome }}</b></span>
                            <p>Sócio número {{ $socio->numero }} <br> Desde {{ \Carbon\Carbon::parse($socio->data_inicio)->format('d-m-Y')}}</p>

                            <a href="{{ route('showSocio', ['socio' => $socio->id]) }}" class="secondary-content btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">mode_edit</i></a>

                        </li>

                    @endforeach

                </ul>

                {{ $socios->links() }}

            </div>

        </div>

        <div class="col l4 m12 s12">
            <div class="caixa-delimitadora-fina">

                <h5>Por Aceitar</h5>

                <div class="divider"></div>

                @if (count($propostas) == 0)
                    <p>Não existem propostas de sócio por aceitar</p>
                @endif()

                <ul class="collection">

                    @foreach ($propostas as $proposta)

                        <li class="collection-item avatar">

                            {{ Html::image('storage/uploads/avatars/socios/' . $proposta->imagem, 'Imagem de perfil de ' . $proposta->nome, ['class' => 'circle']) }}
                            <span class="title"><b>{{ $proposta->nome  }}</b></span>
                            <p>{{ $proposta->email }} <br>{{ \Carbon\Carbon::parse($socio->created_at)->format('d-m-Y')}}</p>

                            <a href="{{ route('showSocio', ['socio' => $proposta->id]) }}" class="secondary-content btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">mode_edit</i></a>

                        </li>

                    @endforeach

                </ul>

            </div>
        </div>


    </div>

@endsection