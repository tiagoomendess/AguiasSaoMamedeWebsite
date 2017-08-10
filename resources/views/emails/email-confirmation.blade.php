@extends('layouts.email-layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
    <title>Confirmação de Email</title>
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
                        {!! $html_body !!}
                    </div>
                </div>

                <div class="col s12 m12 l12">
                    <div class="email-footer">
                        {!! $html_footer !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection