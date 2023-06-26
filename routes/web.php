<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Users;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Brands;
use App\Http\Livewire\Models;
use App\Http\Livewire\Sellers;
use App\Http\Livewire\Auctions;
use App\Http\Livewire\Notifications;
use App\Http\Livewire\OffersList;
use App\Http\Livewire\customFields;
use App\Http\Livewire\globalFields;
use App\Http\Livewire\Admins;
use App\Http\Livewire\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login;

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

Route::redirect('/', 'login');
Route::post('/admin/login', [Login::class, 'index']);
Route::group(['middleware' => 'protected'], function () {
    Route::get('/users', Users::class);
    Route::get('/categories', Categories::class);
    Route::get('/brands', Brands::class);
    Route::get('/models', Models::class);
    Route::get('/sellers', Sellers::class);
    Route::get('/auctions', Auctions::class);
    Route::get('/notifications', Notifications::class);
    Route::get('/offers', OffersList::class);
    Route::get('/custom/fields', customFields::class);
    Route::get('/global/fields', globalFields::class);
    Route::get('/admins', Admins::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');   
});