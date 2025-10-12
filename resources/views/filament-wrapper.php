@extends('layouts.admin')

@section('page-title','Filament Dashboard')

@section('content')
    <div class="w-full h-[80vh]">
        {{-- arahkan langsung ke panel Filament --}}
        <iframe src="{{ url(config('filament.path', 'admin')) }}" class="w-full h-full border-0 rounded-lg shadow"></iframe>
    </div>
@endsection


