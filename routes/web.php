<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\PostController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/{anypath}', [HomeController::class, 'index']);


// Category Route Define
Route::post('/add-category', [CategoryController::class, 'store']);
Route::post('/get-category', [CategoryController::class, 'getCategory']);
Route::post('/category-update/{slug}', [CategoryController::class, 'edit']);
Route::post('/category-update', [CategoryController::class, 'update']);
Route::post('/category/status/{id}', [CategoryController::class, 'status']);
Route::post('/category/delete', [CategoryController::class, 'deleteItems']);
Route::post('/category/inactive', [CategoryController::class, 'Inactive']);
Route::post('/category/active', [CategoryController::class, 'Active']);

// Post Route Define
Route::prefix('/post')->group(function () {
    Route::post('/manage', [PostController::class, 'index']);
    Route::post('/filter', [PostController::class, 'Filter_Post']);
    Route::post('/destroy', [PostController::class, 'Destroy']);
    Route::post('/status', [PostController::class, 'Status']);
});
