@extends('painel.layouts.default-page')

@section('page_title')
    @lang('menu.add_socio')
@endsection

@section('page_content')
    <p>Este é o formulario para criar um novo sócio. Depois de criado, o sócio não terá a sua cota paga.</p>

    <form action="/socio/store" method="POST">

        <div class="row">
            <div class="input-field col s12">
                <input name="numero" id="numero" type="number" class="validate" required>
                <label for="numero">Numero de sócio</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="nome" id="nome" type="text" class="validate" required>
                <label for="nome">Nome Completo</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="cc" id="cc" type="text" class="validate">
                <label for="cc">Número de Cartão de Cidadão</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="email" id="email" type="email" class="validate">
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

            <div class="file-field input-field">
                <div class="btn">
                    <span>Fotografia</span>
                    <input type="file" accept="image/*" id="capture" capture="camera">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
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