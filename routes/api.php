<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/register', [AuthController::class, 'register']);
// ...
Route::get('/login', [AuthController::class, 'login']);
use Illuminate\Support\Facades\Http;

Route::post('/chat', function (Request $request) {
    $response = Http::post('https://api.openai.com/v1/engines/davinci-codex/completions', [
        'prompt' => $request->input('message'),
        'max_tokens' => 50,
    ])->header('Authorization', 'Bearer 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');

    return $response->json();
});
