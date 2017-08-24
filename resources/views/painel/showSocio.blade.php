@extends('painel.layouts.default-page')

@section('page_title')
    Sócio número {{ $socio->numero }}
@endsection

@section('page_content')

    <div class="row">
        <div class="col l8 m12 s12">

            <div class="row">
                <div class="col l4 m4 s12">
                    <div class="caixa-delimitadora-fina">
                        {{ Html::image('storage/uploads/avatars/socios/' . $socio->imagem, 'Imagem de perfil de ' . $socio->nome, ['style' => 'width:100%']) }}
                    </div>
                </div>
                <div class="col l8 m8 s12">
                    <div class="caixa-delimitadora-fina">
                        <p class="flow-text"><b>Nome:</b> {{ $socio->nome }}</p>
                        <p class="flow-text"><b>Morada:</b> {{ $morada->rua . ' Nº ' . $morada->numero }} <br> {{ $morada->codigo_postal . ' ' . $morada->localidade . ', ' . $morada->cidade . ', ' . $morada->pais }}</p>
                        <p class="flow-text"><b>Email:</b> {{ $socio->email }}</p>
                        <p class="flow-text"><b>Telemovel/Telefone:</b> {{ $socio->telemovel }}</p>
                        <p class="flow-text"><b>Cartão de Cidadão:</b> {{ $socio->cartao_cidadao }}</p>
                        <p class="flow-text"><b>Sócio desde:</b> {{ \Carbon\Carbon::parse($socio->data_inicio)->format('d-m-Y') }}</p>

                        <p class="flow-text"><b>Cotas:</b>
                            @if(Carbon\Carbon::now()->timestamp > \Carbon\Carbon::parse($socio->cotas_ate)->timestamp)
                                Até {{ \Carbon\Carbon::parse($socio->cotas_ate)->format('d-m-Y') }}<span class="new badge red" data-badge-caption="">Em Atraso</span>
                            @else
                                Até {{ \Carbon\Carbon::parse($socio->cotas_ate)->format('d-m-Y') }}<span class="new badge green" data-badge-caption="">Em dia</span>
                            @endif
                        </p>
                        <p class="flow-text"><b>Estado:</b>
                            @if($socio->estado == 1)
                                Aceite
                            @else
                                Por aceitar
                            @endif
                        </p>

                    </div>
                </div>
            </div>


        </div>

        <div class="col l4 m12 s12">
            <div class="row">
                <div class="col s12">
                    <div class="caixa-delimitadora-fina">
                        <a href="{{ route('socios') }}" class="waves-effect waves-light btn green" style="width:100%">Voltar</a>

                        <a href="{{ route('editSocio', $socio) }}" class="waves-effect waves-light btn blue" style="width:100%; margin-top: 5px">Editar</a>

                        <a class="waves-effect waves-light btn orange" style="width:100%; margin-top: 5px">Atualizar Cotas</a>

                        <a class="waves-effect waves-light btn modal-trigger red" href="#modal-eliminar" style="width:100%; margin-top: 5px">Eliminar</a>

                        <!-- Modal Structure -->
                        <div id="modal-eliminar" class="modal">
                            <div class="modal-content">
                                <div class="col s10 m10 l10 offset-l1 offset-m1 offset-s1">
                                    <h4 class="center">Eliminar Sócio Número {{ $socio->numero }}</h4>
                                    <p class="center flow-text">Tem a certeza que pretende eliminar <b>{{ $socio->nome }}</b> da lista de sócios?</p>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="col s10 m10 l10 offset-l1 offset-m1 offset-s1">
                                    <div class="row">
                                        <div class="col s6">
                                            <a href="#" class="modal-action modal-close waves-effect waves-green btn green right">Não</a>
                                        </div>

                                        <div class="col s6">
                                            <a href="{{ route('destroySocio', $socio->id) }}" class="modal-action modal-close waves-effect waves btn red left">Sim</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('after-scripts')
    <script>
        $(document).ready(function(){
            // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
            $('#modal-eliminar').modal();
        });
    </script>
@endsection