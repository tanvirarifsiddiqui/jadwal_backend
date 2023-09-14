<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;


Route::get('getCountry',[AppController::class, 'getCountry']);
Route::get('getState/{contryId}',[AppController::class, 'getState']);
Route::get('getCity/{stateId}',[AppController::class, 'getCity']);