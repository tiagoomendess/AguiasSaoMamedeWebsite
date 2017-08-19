@extends('painel.layouts.default-page')

@section('page_title')
    Socio {{ $socio->numero }}
@endsection

@section('page_content')
{{ $socio }}
@endsection