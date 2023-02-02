<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article=Article::where('user_id',auth()->user()->id)->orderBy('id', 'desc')->paginate(6);
        return view('dashboard', compact('article'));
    }

    public function show2(Article $article){
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' =>'required|max:50|min:3',
            'descripcion' =>'required|max:255',
            'pvp' => 'required|numeric|max:999|min:1',
            'stock' =>'required|numeric|max:999|min:0',
            'imagen' =>'required|image|max:2040'
        ]);

        $img = $request->imagen->store('articles');

        Article::create([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'pvp' => $request->pvp,
            'stock' => $request->stock,
            'imagen' => $img,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('dashboard')->with('mensaje', 'El articulo se creo correctamente');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    public function showPublic(Article $article){
        return view('articles.showPublic', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'nombre' =>'required|max:50|min:3',
            'descripcion' =>'required|max:255',
            'pvp' => 'required|numeric|max:999|min:1',
            'stock' =>'required|numeric|max:999|min:0',
        ]);

        $img = ($request->imagen) ? $request->imagen->store('articles') : $article->imagen;
        $img1 = $article->imagen;

        $article->update([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'pvp' => $request->pvp,
            'stock' => $request->stock,
            'imagen' => $img,
            'user_id' => auth()->user()->id
        ]);

        if($request->img){
            Storage::delete($img1);
        }

        return redirect()->route('dashboard')->with('mensaje', 'El articulo se edito correctamente');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        Storage::delete($article->imagen);
        $article->delete();
        return redirect()->route('dashboard')->with('mensaje', 'El articulo se elimino correctamente');;
    }
}
