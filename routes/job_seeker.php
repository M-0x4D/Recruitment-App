<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Models\Job;
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

// Route::get('/register', function (Request $request) {
//     return response()->json(['seeker' => 'fjhef']);
// });

Route::get('available-jobs', [JobController::class,'index']);
Route::post('apply', [ApplicationController::class,'apply']);
