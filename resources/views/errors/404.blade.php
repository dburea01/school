@extends('layout')

@section('title', 'erreur - 404')

@section('content')


@if (isset($exception))
<h1 class="text-center">{{ $exception->getMessage() }}</h1>
@else
<h1 class="text-center">PAGE INCONNUE...</h1>
@endif

@endsection