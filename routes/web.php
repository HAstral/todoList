<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('create');
// });
// Route::redirect('/','customer/createPage')->name('post#home'); //same as below one
// Route::get('/',[PostController::class,'create'])->name('post#home');
Route::redirect('/','customer/createPage')->name('post#home');
Route::get('customer/createPage',[PostController::class,'create'])->name('post#createPage');
Route::post('post/create', [PostController::class,'postCreate'])->name('post#create');
Route::get('/post/delete/{id}',[PostController::class,'postDelete'])->name('post#delete');
// Route::delete('/post/delete/{id}',[PostController::class,'postDelete'])->name('post#delete');
Route::get('post/updatePage/{id}',[PostController::class,'updatePage'])->name('post#update');
Route::get('post/editPage/{id}',[PostController::class,'editPage'])->name('post#editPage');
Route::post('post/update',[PostController::class,'update'])->name('post#updatePage');
//db relation test
Route::get('product/list',function(){
   $data= Product::select('*')
   ->join('categories','products.category_id','categories.id')
   ->get();
});
Route::get('order/list',function(){
    $data=Order::get();
});
