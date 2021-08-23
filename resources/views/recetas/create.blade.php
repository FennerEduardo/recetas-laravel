@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" />
@endsection

@section('botones')
<a href="{{ route('recetas.index')}}" class="btn btn-primary mr-2 text-uppercase font-weight-bold">
    <svg class="w-6 h-6 icono" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
    Volver
</a>
@endsection

@section('content')

<h2 class="text-center mb-5">Crear Nueva Receta</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form action="{{ route('recetas.store')}}" method="POST" novalidate enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="titulo">Título Receta</label>
                <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" id="titulo" value=" {{ old('titulo')}}" placeholder="Título Receta">
                @error('titulo')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select class="form-control @error('categoria') is-invalid @enderror" name="categoria" id="categoria">
                    <option value="">-- Seleccion --</option>
                    @foreach ($categorias as  $categoria)
                    <option value="{{$categoria->id}}" {{ old('categoria') == $categoria->id ? 'selected' : ''}}>{{$categoria->nombre}}</option>
                    @endforeach
                </select>
                @error('categoria')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="preparacion">Preparación</label>
                <input type="hidden" name="preparacion" id="preparacion" value="{{ old('preparacion')}}" >
                <trix-editor input="preparacion" class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>
                @error('preparacion')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="ingredientes">Ingredientes</label>
                <input type="hidden"  name="ingredientes" id="ingredientes" value="{{ old('ingredientes')}}">
                <trix-editor input="ingredientes" class="form-control @error('ingredientes') is-invalid @enderror"></trix-editor>
                @error('ingredientes')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="imagen">Elige la imagen</label>
                <input type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen" id="imagen" value="{{ old('imagen')}}">                
                @error('imagen')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="submit" value="Agregar Receta" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" defer></script>
@endsection
