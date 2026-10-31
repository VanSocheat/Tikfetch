<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProfileController,DownloadController,AuthController,DashboardController,AdminController};
Route::get('/',[ProfileController::class,'index'])->name('home');
Route::post('/lookup',[ProfileController::class,'lookup'])->middleware('throttle:12,1')->name('lookup');
Route::middleware('guest')->group(function(){Route::get('/login',[AuthController::class,'loginForm'])->name('login');Route::post('/login',[AuthController::class,'login'])->middleware('throttle:5,1');Route::get('/register',[AuthController::class,'registerForm'])->name('register');Route::post('/register',[AuthController::class,'register'])->middleware('throttle:5,1');});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth'])->group(function(){Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');Route::post('/download',[DownloadController::class,'download'])->middleware('throttle:10,1')->name('download');Route::get('/admin',[AdminController::class,'index'])->name('admin');Route::patch('/admin/users/{user}',[AdminController::class,'updateUser'])->name('admin.user.update');});
