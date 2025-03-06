<?php

use App\Http\Controllers\printController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| DEFAULT WEB ROUTES
|--------------------------------------------------------------------------

Route::get('/', function () {
    return view('welcome');
});

*/
/*Route::get('/contratto', function(){
    return view('contratto');
});
Route::get('/contrattotw', function(){
    return view('contrattotw');
});
*/

//login
Route::redirect('/login', '/login')->name('login');
Route::middleware(['auth'])->group(function(){
    Route::get('/{record}/stampacontratto', [printController::class, 'printContratto'])->name('contratto.pdf.stampa');
    Route::get('/{record}/whatsapp', [printController::class, 'printWhatsapp'])->name('whatsapp.pdf.stampa');
    //Route::get('/{record}/interesse', function(){return view('interesse');});
    Route::get('/{record}/privacy', [printController::class, 'printPrivacy'])->name('privacy.pdf.stampa');
    Route::get('/payments/{record}/ricevuta', [printController::class, 'printRicevuta'])->name('ricevuta.pdf.stampa');
    //Route::get('/user/attendance-registration')->name('attendance-registration');
});
