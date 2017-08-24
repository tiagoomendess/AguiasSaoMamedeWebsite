@extends('painel.layouts.default-page')

@section('page_title')
    @lang('menu.add_socio')
@endsection

@section('page_content')
    <p>Este é o formulario para criar um novo sócio. Depois de criado, o sócio não terá a sua cota paga.</p>

    <div class="row">
        <div class="col l12 m12 s12">
            @include('parcial.errors', ['errors' => $errors])
        </div>
    </div>

    <form enctype="multipart/form-data" action="{{ route('storeSocio') }}" method="POST">

        <div class="row">
            <div class="input-field col s12 m6">
                <input name="numero" id="numero" type="number" class="validate" value="{{$proximoNumero }}" required>
                <label for="numero">Numero de sócio</label>
            </div>

            <div class="file-field input-field col s12 m6">
                <div class="btn">
                    <span>Fotografia</span>
                    <input type="file" name="fotografia" accept="image/*" id="capture" capture="camera">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="nome" id="nome" type="text" class="validate" value="{{old('nome')}}" required>
                <label for="nome">Nome Completo</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="cc" id="cc" type="text" class="validate" value="{{old('cc')}}">
                <label for="cc">Número de Cartão de Cidadão</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="email" id="email" type="email" class="validate" value="{{old('email')}}">
                <label for="email">Email</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="telemovel" id="telemovel" type="text" class="validate" value="{{old('telemovel')}}">
                <label for="telemovel">Número de Telemovel</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input id="data_inicio" name="data_inicio" type="text" class="datepicker" value="">
                <label for="data_inicio">Sócio desde</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 m12 l4 offset-l4">
                <a class="waves-effect waves-light btn" onclick="MoradaAuto()" style="width:100%">Morada Auto</a>
            </div>
        </div>


        <div class="row">
            <div class="input-field col s9">
                <input name="rua" id="rua" type="text" class="validate" value="{{old('rua')}}">
                <label for="rua">Rua</label>
            </div>

            <div class="input-field col s3">
                <input name="numero_porta" id="numero_porta" type="number" class="validate" value="{{old('numero_porta')}}">
                <label for="numero_porta">Número</label>
            </div>
        </div>

        <div class="row">

            <div class="input-field col s6 m6 l3">
                <input name="codigo_postal" id="codigo_postal" type="text" class="validate" value="{{old('codigo_postal')}}">
                <label for="codigo_postal">Código Postal</label>
            </div>

            <div class="input-field col s6 m6 l3">
                <input name="localidade" id="localidade" type="text" class="validate" value="{{old('localidade')}}">
                <label for="localidade">Freguesia</label>
            </div>

            <div class="input-field col s12 m6 l3">
                <input name="cidade" id="cidade" type="text" class="validate" value="{{old('cidade')}}">
                <label for="cidade">Cidade</label>
            </div>

            <div class="input-field col s12 m6 l3">
                <select class="browser-default" name="pais">
                    <option value="Portugal" selected>Portugal</option>
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

        <div class="center">
            <button class="btn waves-effect waves-light btn-large green" type="submit" name="action">Criar Sócio
                <i class="material-icons right">send</i>
            </button>
        </div>


    </form>
@endsection

@section('after-scripts')
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

        function MoradaAuto() {

            var codigo_postal = document.getElementById('codigo_postal');
            codigo_postal.setAttribute('value', '4750-');
            codigo_postal.classList.add('invalid');

            var localidade = document.getElementById('localidade');
            localidade.setAttribute('value', 'Vilar do Monte');
            localidade.classList.add('valid');

            var cidade = document.getElementById('cidade');
            cidade.setAttribute('value', 'Barcelos');
            cidade.classList.add('valid');

            Materialize.updateTextFields();
        }

    </script>
@endsection