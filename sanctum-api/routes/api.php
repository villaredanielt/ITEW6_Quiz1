<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/home', [PostController::class,'index']);
Route::get('/search/{id}',[PostController::class, 'show']);
Route::post('/store',[PostController::class, 'store']);
Route::put('/update/{id}', [PostController::class,'update']);
Route::delete('/delete/{id}', [PostController::class,'destroy']);





