@extends('layouts.layout')

@section('head')
    <title>Registar</title>
@endsection

@section('corpo')


    <div class="container">
        <div class="row">
            <div class="col l6 m12 s12">
                <form method="POST" action="/register" class="col s12">

                    <div class="row">
                        <div class="input-field col s6">
                            <input name="nome" id="first_name" type="text" class="validate" required>
                            <label for="first_name">Nome</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="apelido" id="last_name" type="text" class="validate" required>
                            <label for="last_name">Apelido</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="email" id="email" type="email" class="validate" required>
                            <label for="email">Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="password" id="password" type="password" class="validate" required>
                            <label for="password">Password</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="password_confirmation" id="password_confirm" type="password" class="validate" required>
                            <label for="password_confirm">Repetir Password</label>
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <button class="btn waves-effect waves-light" type="submit" name="action">Registar
                        <i class="material-icons right">send</i>
                    </button>
                </form>

                @if(count($errors))
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                @endif
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            Materialize.updateTextFields();
        });
    </script>

@endsection
