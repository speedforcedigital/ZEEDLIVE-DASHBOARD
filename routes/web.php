<?php

use App\Http\Controllers\DashboardNotificationsController;
use App\Http\Controllers\RolesController;
use App\Http\Livewire\Orders;
use App\Http\Livewire\ReportedOrders;
use App\Http\Livewire\Roles;
use App\Http\Livewire\SellerReportedOrders;
use App\Http\Livewire\Users;
use App\Http\Livewire\Admins;
use App\Http\Livewire\Brands;
use App\Http\Livewire\Models;
use App\Http\Livewire\Listing;
use App\Http\Livewire\Product;
use App\Http\Livewire\Sellers;
use App\Http\Controllers\Login;
use App\Http\Livewire\Auctions;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Collection;
use App\Http\Livewire\OffersList;
use App\Http\Livewire\customFields;
use App\Http\Livewire\globalFields;
use App\Http\Livewire\Notifications;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CategoryManager;
use App\Http\Livewire\LoginController;
use App\Http\Livewire\LiveStreamProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\Wallets;

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
Route::get('/json-data-feed', [DashboardController::class, 'getDataFeed'])->name('json_data_feed');

Route::redirect('/', 'login');
Route::post('/admin/login', [Login::class, 'index']);
Route::group(['middleware' => 'protected'], function () {

    Route::middleware('check.permissions:App  User')->get('/users', Users::class)->name("users");
    Route::get('/get-sales-data', [DashboardController::class, 'getSalesData']);
    Route::get('/get/users-by-age', [DashboardController::class, 'getUsersByAge']);
    Route::get('/get/users-by-gender', [DashboardController::class, 'getUsersByGender']);
    Route::get('/user/{id}', [DashboardController::class, 'userView'])->name("user.show");
    Route::get('/collection/{id}', [DashboardController::class, 'collectionView'])->name("collection.show");

    Route::get('/product/{id}',[ProductController::class, 'view'])->name("product.show");
    Route::get('/categories', Categories::class);

    Route::get('/manage/category', CategoryManager::class)->name('category.manager');

    Route::get('/brands', Brands::class);
    Route::get('/orders', Orders::class);
    //reported orders
    Route::get('/reported/orders', ReportedOrders::class);
    Route::get('/seller/reported/orders', SellerReportedOrders::class);

    Route::middleware('check.permissions:Wallets')->get('/wallets', Wallets::class)->name('wallet.index');
    Route::get('/collections', Collection::class)->name("collections.index");
    Route::get('/models', Models::class);
    Route::middleware('check.permissions:Seller Verification')->get('/sellers', Sellers::class)->name('sellers.index');
    Route::get('/auctions', Auctions::class);
    Route::get('/products/standard', Product::class)->name("standard.products");
    Route::get('/products/live-stream', LiveStreamProduct::class)->name("livestream.products");
    Route::get('/products/listings', Listing::class)->name("listings.products");
    Route::get('/notifications', Notifications::class);
    Route::middleware('check.permissions:Offers')->get('/offers', OffersList::class)->name("offers");
    Route::middleware('check.permissions:Custom Field')->get('/custom/fields', customFields::class);
    Route::middleware('check.permissions:Global Field')->get('/global/fields', globalFields::class);
    Route::middleware('check.permissions:Admin User')->get('/admins', Admins::class)->name("admins");
    Route::get('/roles', Roles::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //sales data
    Route::get('/get-chart-data', [DashboardController::class, 'getChartData']);
    Route::get('/get-commission-chart-data', [DashboardController::class, 'getCommissionChartData']);
    Route::get('/get-sales-chart-details/{name}', [DashboardController::class, 'getChartDataAjax']);
    Route::get('/get-commission-chart-details/{name}', [DashboardController::class, 'getCommissionChartDataAjax']);

    //for Cpanel
    Route::get('/optimize-clear', function () {
        Artisan::call('optimize:clear');
        return 'success';
    });

    Route::get('/zego/{productID}',[\App\Http\Controllers\Zego::class,'getToken']);
    Route::get('/get/signature/{productID}', [\App\Http\Controllers\Zego::class, 'getSignature']);
    Route::get('/convert/product/{id}', [ProductController::class, 'convertProduct'])->name("product.convert");


});
