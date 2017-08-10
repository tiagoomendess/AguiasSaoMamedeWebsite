@extends('layouts.email-layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
    <title>@lang('emails.password_reset_subject')</title>
@endsection

@section('body')

    <div class="container">
        <div class="row">
            <div class="col s12 m8 l6">

                <div class="col s12 m12 l12">
                    <div class="email-head">
                        <h1>{{ $assunto }}</h1>
                    </div>
                </div>

                <div class="col s12 m12 m12" >
                    <div class="email-body">
                        <p>@lang('emails.password_reset_greeting', ['nome' => $nome, 'apelido' => $apelido])</p>

                        <p>@lang('emails.password_reset_explain')</p>

                        <p><a href="{{ $link }}">{{ $link }}</a></p>

                        <p>@lang('emails.password_reset_goodbye')</p>

                    </div>
                </div>

                <div class="col s12 m12 l12">
                    <div class="email-footer">
                        <p>
                            @lang('geral.clube_full') <br>
                            @lang('geral.dominio') <br>
                            @lang('geral.main_email') <br>
                            @lang('geral.morada')
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection