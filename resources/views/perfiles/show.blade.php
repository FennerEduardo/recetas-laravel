@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                @if ($perfil->imagen)
                <img src="/storage/{{$perfil->imagen}}" alt="{{$perfil->usuario->name}}" class="w-100 rounded-circle">                    
                @endif
            </div>
            <div class="col-md-7 mt-5 mt-md-0">
                <h2 class="text-center mb-2 text-primary">{{$perfil->usuario->name}}</h2>
                <a href="{{$perfil->usuario->url}}">Visitar Sitio Web</a>
                <div class="biografia">
                    {!! $perfil->biografia !!}
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center my-5">Recetas Creadas por: {{$perfil->usuario->name}}</h2>
    <div class="container">
        <div class="row mx-auto bg-white p-4">
            @forelse ($recetas as $receta)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="/storage/{{$receta->imagen}}" alt="{{$receta->titulo}}" class="card-img-top">
                        <div class="card-body">
                            <h3>{{$receta->titulo}}</h3>
                            <a href="{{route('recetas.show', ['receta' => $receta->id])}}" class="btn btn-primary d-block mt-4 text-uppercase font-weight-bold">Ver Receta</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center w-100">
                    No hay Recetas aún...
                </p>
            @endforelse
            <div class="col-12 mt-4 justify-content-center d-flex">
                {{$recetas->links()}}
            </div>
        </div>
    </div>
@endsection
