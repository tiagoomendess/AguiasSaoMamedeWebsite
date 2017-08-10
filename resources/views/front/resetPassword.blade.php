@extends('layouts.default-page')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>São Mamede | Redifinir password </title>
@endsection

@section('conteudo')
    <div class="row">
        <div class="col s12 m12 l6 offset-l3 center">
            <h1 class="center-align">@lang('auth.reset_password_title')</h1>
            <p>@lang('auth.reset_password_tip')</p>
        </div>
    </div>

    <div class="row">

        <div class="col l6 m12 s12 center offset-l3">
            @include('parcial.errors', ['errors' => $errors])
        </div>

        <div class="col l6 m12 s12 center offset-l3">

            @if(isset($infos))
                @include('parcial.info', ['infos' => $infos])

            @else
                <form method="POST" action="/password/reset">

                    {!! csrf_field() !!}

                    <div class="row">

                        <div class="input-field col s12 m12 l12">
                            <input name="email" id="email" type="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">@lang('auth.form_email') @lang('')</label>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            {!! app('captcha')->display($attributes = [], $lang = Lang::getLocale()) !!}
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('auth.reset_password_btn')
                                <i class="material-icons right">send</i>
                            </button>
                        </div>

                    </div>
                </form>
            @endif

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            Materialize.updateTextFields();
        });
    </script>
@endsection