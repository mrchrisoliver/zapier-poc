<?php

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->post('/hook', function (Request $request) {
    $data = $request->collect();
    \Illuminate\Support\Facades\Log::info('zapier', $request->all());

    Subscription::updateOrCreate(
        ['user_id' => auth()->user()->id, 'name' => 'Zapier'],
        ['post_url' => $request['hookUrl']],
    );
    return response()->json(['url' => $request->all('hookUrl')]);
});

Route::middleware('auth:api')->delete('/hook/unsub', function (Request $request) {
    \Illuminate\Support\Facades\Log::info('zapier-unsub', $request->all());

     dd($request);
});

Route::middleware('auth:api')->get('/hook/data', function (Request $request) {
    \Illuminate\Support\Facades\Log::info('zapier-data', $request->all());

    return response()->json(\App\Models\Client::all());
});
