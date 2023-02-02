<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactoController;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $article = Article::with('user')->where('stock', '!=', 0)->orderBy('id', 'desc')->paginate(10);
    return view('welcome', compact('article'));
})->name('inicio');

Route::get('articles/showPublic/{article}', [ArticleController::class, 'showPublic'])->name('showPublic');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'
])->group(function () {
    Route::get('/dashboard', [ArticleController::class, 'index'])->name('dashboard');
    Route::get('contacto', [ContactoController::class, 'pintarFormulario'])->name('contacto.pintar');
    Route::post('contacto', [ContactoController::class,'procesarFormulario'])->name('contacto.procesar');
    Route::resource('articles', ArticleController::class);
});
