@extends('layout')

@section('seo')
    <title>{!! config('app.name') !!}</title>
@endsection

@section('content')
    <div class="flex flex-col justify-center items-center w-full">
        <h1 class="text-4xl font-bold mt-[300px] mb-6 text-primary">Welcome to {{ config('app.name') }}</h1>
    </div>
@endsection
