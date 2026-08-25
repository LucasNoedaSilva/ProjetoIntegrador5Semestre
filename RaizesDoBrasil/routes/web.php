<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

/*Route::get('/', function () {
    return view('home');
});*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/aboutus', function () { return view('aboutus');});
   
//categorias
Route::get("/category/create", [CategoryController::class, "create"]);
Route::post("/category/store", [CategoryController::class, "store"]);
Route::get("/category", [CategoryController::class, "index"]);
Route::get("/category/edit/{category}", [CategoryController::class, "edit"]);
Route::post("/category/update/{category}", [CategoryController::class, "update"]);
Route::get("/category/show/{category}", [CategoryController::class, "show"]);
Route::get("/category/delete/{category}", [CategoryController::class, "delete"]);

//produtos
Route::get("/product/create", [ProductController::class, "create"]);
Route::post("/product/store", [ProductController::class, "store"]);
Route::get("/product", [ProductController::class, "index"]);
Route::get("/product/edit/{product}", [ProductController::class, "edit"]);
Route::post("/product/update/{product}", [ProductController::class, "update"]);
Route::get("/product/show/{product}", [ProductController::class, "show"]);
Route::get("/product/delete/{product}", [ProductController::class, "delete"]);

//ingredientes
Route::get("/ingredient/create", [IngredientController::class, "create"]);
Route::post("/ingredient/store", [IngredientController::class, "store"]);
Route::get("/ingredient", [IngredientController::class, "index"]);
Route::get("/ingredient/edit/{ingredient}", [IngredientController::class, "edit"]);
Route::post("/ingredient/update/{ingredient}", [IngredientController::class, "update"]);
Route::get("/ingredient/show/{ingredient}", [IngredientController::class, "show"]);
Route::get("/ingredient/delete/{ingredient}", [IngredientController::class, "delete"]);

//pedido
Route::get("/order/create", [OrderController::class, "create"]);
Route::post("/order/store", [OrderController::class, "store"]);
Route::get("/order", [OrderController::class, "index"]);
Route::get("/order/edit/{order}", [OrderController::class, "edit"]);
Route::post("/order/update/{order}", [OrderController::class, "update"]);
Route::get("/order/show/{order}", [OrderController::class, "show"]);
Route::get("/order/delete/{order}", [OrderController::class, "delete"]);
// Rota para o relatório diário
Route::get('/order/report', [OrderController::class, 'dailyReport']);
Route::get('/customer/create', [CustomerController::class, 'create']);
Route::post('/customer/store', [CustomerController::class, 'store']);
Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit']);
Route::post('/customer/update/{id}', [CustomerController::class, 'update']);
Route::get('/customer/show/{id}', [CustomerController::class, 'show']);
Route::get('/customer/delete/{id}', [CustomerController::class, 'delete']);
});

require __DIR__.'/auth.php';
