@extends('layouts.app')

@section('title', 'Landing')

@section('content')
    <a class="font-bold" href="{{ route('orders.index') }}">To Order Page</a>
@endsection