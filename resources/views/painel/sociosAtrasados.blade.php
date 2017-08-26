@extends('painel.layouts.default-page')

@section('page_title')
    Sócios Atrasados
@endsection

@section('page_content')

    @include('painel.parcial.message')

    <div class="row">
        <div class="col s12 m12 l8">
            <div class="caixa-delimitadora-fina">

                <p class="flow-text">Existem neste momento <b>{{ $socios->count() }}</b> socios com cotas em atraso.</p>

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
            </div>

        </div>

        <div class="col s12 m12 l4">
            <div class="caixa-delimitadora-fina">

                    <a style="width: 100%"
                       class="waves-effect waves-light btn green darken-3 @if ($socios->count() < 1) disabled @endif">
                        <i class="material-icons left"></i>Enviar Email</a>

                    <a style="width: 100%; margin-top: 5px;"
                       class="waves-effect waves-light btn blue darken-2 @if ($socios->count() < 1) disabled @endif">
                        <i class="material-icons left"></i>Enviar SMS</a>

                <br>
            </div>

        </div>
    </div>







@endsection