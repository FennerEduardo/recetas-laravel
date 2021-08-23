<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // auth()->user()->recetas->dd();
        // $recetas = auth()->user()->recetas;
        $usuario = auth()->user();
        $recetas = Receta::where('user_id', $usuario->id)->paginate(10);
        return view('recetas.index')->with('recetas', $recetas)->with('usuario', $usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::table('categoria_receta')->get()->pluck('nombre', 'id')->dd();
        //obtener categorías sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

        // Obtener categorías con modelos
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.create')->with('categorias',  $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validación 
        $data = request()->validate([
            'titulo' => 'required|string|min:6',
            'preparacion' => 'required|string',
            'ingredientes' => 'required|string',
            'imagen' => 'required|image',
            'categoria' => 'required|integer',
        ]);

        // obtener la ruta de la imagen
        $ruta_imagen = $request['imagen']->store('uploads-recetas', 'public');

        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
        $img->save();

        // almacenar en la base de datos sin modelo
        // DB::table('recetas')->insert([
        //     'titulo' => $data['titulo'],
        //     'preparacion' => $data['preparacion'],
        //     'ingredientes' => $data['ingredientes'],
        //     'imagen' => $ruta_imagen,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $data['categoria'],
        // ]);

        // almacenar en la base de datos con modelo
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'preparacion' => $data['preparacion'],
            'ingredientes' => $data['ingredientes'],
            'imagen' => $ruta_imagen,
            'user_id' => Auth::user()->id,
            'categoria_id' => $data['categoria'],
        ]);

        //redireccionar al controlador de index
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //Obtener si el usuario actual le gusta la receta y está autenticado
        $like = (auth()->user()) ? auth()->user()->meGusta->contains($receta->id) : false;

        // contar los likes de la receta
        $likes = $receta->likes->count();

        return view('recetas.show', compact('receta', 'like', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        // Revisar el policy
        $this->authorize('view', $receta);
        // Obtener categorías con modelos
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        // Revisar el policy
        $this->authorize('update', $receta);

        //Validación 
        $data = request()->validate([
            'titulo' => 'required|string|min:6',
            'preparacion' => 'required|string',
            'ingredientes' => 'required|string',
            'imagen' => 'nullable|image',
            'categoria' => 'required|integer',
        ]);

        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];


        // Si el usuario sube una nueva imagen
        if (request('imagen')) {
            // obtener la ruta de la imagen
            $ruta_imagen = $request['imagen']->store('uploads-recetas', 'public');
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
            $img->save();

            $receta->imagen = $ruta_imagen;
        }
        $receta->save();

        //redireccionar al controlador de index
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        // Revisar el policy
        $this->authorize('delete', $receta);
        $receta->delete();
        //redireccionar al controlador de index
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $busqueda = $request['buscar'];
        $recetas = Receta::where('titulo', 'like', '%'.$busqueda.'%')->paginate(10);
        $recetas->appends(['buscar' => $busqueda]);
        return view('busquedas.show', compact('recetas', 'busqueda'));
    }
}
