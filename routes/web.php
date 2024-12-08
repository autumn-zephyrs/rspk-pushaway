<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use App\Livewire\Welcome;
use App\Livewire\ShowDecks;
use App\Livewire\ShowDeck;
use App\Livewire\ShowArchetypes;
use App\Livewire\ShowArchetype;
use App\Livewire\ShowPlayers;
use App\Livewire\ShowPlayer;
use App\Livewire\ShowArticles;
use App\Livewire\ShowTournaments;
use App\Livewire\ShowStandings;
use App\Livewire\ShowStanding;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Welcome::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('decks', ShowDecks::class)
    ->name('decks');
Route::get('decks/{id}', ShowDeck::class)
    ->name('deck');
Route::get('archetypes/', ShowArchetypes::class)
    ->name('archetypes');
Route::get('archetypes/{id}', ShowArchetype::class)
    ->name('archetype');

Route::get('players', ShowPlayers::class)
    ->name('players');
Route::get('players/{id}', ShowPlayer::class)
    ->name('player');
    
Route::get('articles', ShowArticles::class)
    ->name('articles');
    
Route::get('tournaments', ShowTournaments::class)
    ->name('tournaments');
Route::get('tournaments/{limitless_id}', ShowStandings::class)
    ->name('standings');
Route::get('tournaments/standings/{id}', ShowStanding::class)
    ->name('standing');

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});
