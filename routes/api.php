<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatatanKegiatanController;
use App\Http\Controllers\DetailUserController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserController;
use App\Models\DetailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);
Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();

    return 'tokens are deleted';
});

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendEmailVerificaion'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){

    // Kegiatan
    Route::get('user-kegiatan', [UserController::class, 'getUserForKegiatan']);

    // Status
    Route::get('/user-status', [UserController::class, 'getUserForStatus']);

    // Absen
    Route::get('/list-anak', [UserController::class, 'getListAnak']);

    // Catatan Kegiatan
    Route::get('/list-catatan', [CatatanKegiatanController::class, 'getListCatatan']);




    // User
    Route::get('/user', [UserController::class, 'getUser']);
    Route::get('/user-detail', [UserController::class, 'getUserDetail']);
    Route::post('/update-avatar', [UserController::class, 'updateAvatar']);

    // Absen
    Route::post('/absen', [AbsenController::class, 'Absen']);
    Route::get('/absen', [AbsenController::class, 'getAbsen']);
    Route::get('/guru-absensi', [AbsenController::class, 'getAbsensiGuru']);

    // Detail User
    Route::post('/detail-user', [DetailUserController::class, 'addDetailUser']);
    Route::post('/upload-cv', [DetailUserController::class, 'uploadCv']);
    Route::post('/upload-porto', [DetailUserController::class, 'uploadPorto']);
    Route::get('/detail-user', [DetailUserController::class, 'getDetailUser']);
    Route::get('/detail-userid', [DetailUserController::class, 'getDetailUserId']);

    // Catatan
    Route::post('/add-catatan', [CatatanKegiatanController::class, 'addCatatanKegiatan']);
    Route::get('/get-catatan', [CatatanKegiatanController::class, 'getCatatan']);
    Route::get('/get-catatanid', [CatatanKegiatanController::class, 'getCatatanId']);
    Route::get('/get-detail-catatan-id', [CatatanKegiatanController::class, 'getDetailCatatanById']);
});