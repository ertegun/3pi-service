<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyUserController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// routes/web.php veya routes/api.php

//Route::middleware(['auth:api', 'm2m_auth'])->get('/api/m2m-data', MachineToMachineController::class);


Route::post('/login', [MyUserController::class, 'login']);


//Route::get('/users', [UserController::class, 'index'])->name('index');


Route::get('/get-client-credentials-token', [MyUserController::class, 'getClientCredentialsToken']);
Route::middleware('auth:api')->post('/create-client-secret', [MyUserController::class, 'createClientSecret']);


Route::resource('/users', UserController::class);

Route::resource('/products', ProductController::class);

Route::prefix('auth')->group(function () {
    Route::post('/register', [MyUserController::class, 'register']);
// Yeni bir kullanıcı kaydı oluşturmak için POST isteği kullanılır.
// Bu yol, MyUserController sınıfının register yöntemi tarafından işlenir.
 });