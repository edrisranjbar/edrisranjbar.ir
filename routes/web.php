<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;

Route::get('/', [FrontEndController::class, 'index']);
