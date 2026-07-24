@extends('layout')

@section('title', 'erreur - 400')

@section('content')


@if (isset($exception))
<h1 class="text-center">{{ $exception->getMessage() }}</h1>
@else
<h1 class="text-center">SOUCI ... 400 ...</h1>
@endif

@endsection