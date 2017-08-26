@extends('painel.layouts.default-page')

@section('page_title')
    Sócio número {{ $socio->numero }}
@endsection

@section('page_content')

    @include('painel.parcial.message')

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


                            @if($cotas->count() < 1)
                                <b style="color: red">Sem cotas pagas</b>
                            @else

                                {{ \App\ListaCotas::find($cotas->last()->cota_id)->nome }} <small>Paga em {{ \Carbon\Carbon::parse($cotas->last()->data)->format('d-m-Y') }}</small>

                                @if(\Carbon\Carbon::parse(\App\ListaCotas::find($cotas->last()->cota_id)->data_fim)->year < \Carbon\Carbon::now()->year)
                                    <span class="new badge red" data-badge-caption="">Em Atraso</span>
                                @else
                                    <span class="new badge green" data-badge-caption="">Em Dia</span>
                                @endif

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

                        <a href="#modal-cotas" class="waves-effect waves-light btn orange modal-trigger" style="width:100%; margin-top: 5px">Atualizar Cotas</a>

                        <div id="modal-cotas" class="modal">
                            <div class="modal-content">
                                <div class="col s10 m10 l10 offset-l1 offset-m1 offset-s1">
                                    <h4 class="center">Atualizar Cotas do Sócio Número {{ $socio->numero }}</h4>

                                    <p class="flow-text center">
                                        Este sócio tem <b>{{ $cotas->count() }}</b> cotas pagas registadas no sistema.
                                    </p>

                                        <div class="row">

                                            <div class="input-field col s6 m6 l4 offset-l2">
                                                <input name="data_input" id="data_input" type="text" class="validate" value="{{ old('data', \Carbon\Carbon::now()->format('Y-m-d'))}}" required>
                                                <label for="data_input">Data de pagamento</label>
                                            </div>

                                            <div class="input-field col s6 m6 l4">
                                                <input name="montante_input" id="montante_input" type="number" step="0.01" class="validate" value="10.00" required>
                                                <label for="montante_input">Montante</label>
                                            </div>

                                            <div class="input-field col s12 m12 l6">

                                                <form name="remover_cota_form" action="{{ route('removerCota', $socio->id) }}" method="POST">

                                                    {{ csrf_field() }}

                                                    <input type="hidden">

                                                    <button style="width:100%" class="btn waves-effect waves-light btn-large red right @if ($cotas->count() < 1) disabled @endif" type="submit" name="action">
                                                        Remover Anterior
                                                        <i class="material-icons right">arrow_back</i>
                                                    </button>

                                                </form>

                                            </div>

                                            <div class="input-field col s12 m12 l6">



                                                <form name="pagar_cota_form" id="pagar_cota_form" action="{{ route('pagarCota', $socio->id) }}" method="POST">

                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="data" id="data" value="">
                                                    @if ( $proxima_cota != null)
                                                        <input type="hidden" name="cota_id" value="{{ $proxima_cota->id }}">
                                                    @endif
                                                    <input type="hidden" name="montante" id="montante" value="">

                                                    @if ( $proxima_cota != null)
                                                        <a style="width:100%" class="btn waves-effect waves-light btn-large green left" onclick="pagarCota()"> Pagar {{ $proxima_cota->nome }}
                                                            <i class="material-icons left">arrow_forward</i>
                                                        </a>
                                                    @endif

                                                </form>
                                            </div>

                                            <div class="input-field col s12 m12 l4 offset-l4">
                                                <a style="width:100%" href="#!" class="modal-action modal-close waves-effect waves-green btn-large light-blue center">
                                                    <i class="material-icons left">cancel</i> Cancelar</a>
                                            </div>


                                        </div>

                                </div>

                                <br>

                            </div>

                        </div>

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
            $('#modal-cotas').modal();
        });

        function pagarCota() {

            Materialize.updateTextFields();

            var form = document.getElementById("pagar_cota_form");
            var data_input = document.getElementById("data_input").value;
            var montante_input = document.getElementById("montante_input").value;

            document.getElementById("data").value = data_input;
            document.getElementById("montante").value = montante_input;

            //alert('data_input: ' + data_input + ' | montante_input: ' + montante_input);

            form.submit();

        }
    </script>

@endsection