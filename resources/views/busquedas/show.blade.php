@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="titulo-categoria text-uppercase mt-5 mb-4">Resultados para {{$busqueda}}</h2>
    <div class="row">
        @forelse ($recetas as $receta)
        @include('ui.receta')
        @empty
        <p class="text-center">No hay resultados para tu búsqueda</p>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{$recetas->links()}}
    </div>
</div>

@endsection
