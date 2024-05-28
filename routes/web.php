<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;

Route::get('/', [Controller::class, 'index']);

Route::get('file-upload', [UploadController::class, 'fileUpload'])->name('fileUpload');
Route::post('file-upload', [UploadController::class, 'store' ])->name('store');
Route::post('file-delete', [UploadController::class, 'fileDelete'])->name('excluir');
