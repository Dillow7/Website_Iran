<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ArticleController;
use App\Http\Controllers\Front\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article.show');
