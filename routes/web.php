<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// To welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// To blog page
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
// To about page
Route::get('/about', function () {
    return view('about');
})->name('about');
// To contact page
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
// To single blog post
Route::get('/blog/post', [BlogController::class, 'show'])->name('post.show');
//create blog post
Route::get('/blog/create',[BlogController::class,'create'])->name('post.create');

Route::post('/blog',[BlogController::class,'store'])->name('post.store');


require __DIR__ . '/auth.php';
