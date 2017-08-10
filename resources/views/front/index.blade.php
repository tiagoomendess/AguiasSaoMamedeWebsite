@extends('layouts.layout')

@section('head')
    @include('parcial.head')
    <title>Início | ADCR Águias de S. Mamede</title>
@endsection

@section('body')
    @include('parcial.navbar')

    @if(isset($infos))
        @include('parcial.toast', ['infos' => $infos])
    @endif

    <div class="row">
        <div class="jogos">
            {{Html::image(asset("imagens/jogos.jpg"), 'ADCR Águias de S. Mamede', array('class' => 'img-responsive'))}}

        </div>
    </div>

    <div class="row contactos">
        <div class="col l12 m12 s12 center">
            <a class="waves-effect waves-light btn">Faz-te Socio</a>
        </div>
    </div>

    <div class="row">
        <div class="col l4 m4 s4 marcador">Melhor Marcador</div>
        <div class="col l4 m4 s4 resultados">Ultimos resultados</div>
        <div class="col l4 m4 s4 classificacao">Classificação</div>
    </div>

    @include('parcial.footer')
    @include('parcial.scripts')

@stop