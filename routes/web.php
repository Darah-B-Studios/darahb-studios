<?php

use App\Http\Livewire\Frontpage;
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

Route::group(['middleware' => [
    'auth:sanctum',
    'verified',
    'user_role_access'
]], function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/pages', fn () => view('admin.pages'))->name('pages');
    Route::get('/navigation-menus', fn () => view('admin.navigation-menus'))->name('navigation-menus');
    Route::get('/users', fn () => view('admin.users'))->name('users');
    Route::get('/user-permissions', fn () => view('admin.user-permissions'))->name('user-permissions');
    Route::get('/events', fn () => view('admin.events'))->name('events');
});

/* NB: page_slug must match parameter name in livewire page component */
Route::get('/{page_slug}', Frontpage::class);