<?php

use App\FavouriteJokes;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('favouritejokes/save', 'FavouriteJokesController@store');
Route::delete('favouritejokes/remove', 'FavouriteJokesController@remove');

// Route::post('/save', function (Request $request) {
//     $favouriteJoke = new FavouriteJokes();
//     $favouriteJoke->jokeId = $request->addToFavorites;
//     $favouriteJoke->jokeText = $request->jokeText;
//     $favouriteJoke->visitor = Request::ip();

//     $favouriteJoke->save();
//     return response()->json(['success'=>'Saved succesfully']);
// });

// Route::delete('/delete', function (Request $request) {
//     $favouriteJoke = new FavouriteJokes();
//     $favouriteJoke->id = $request->id;

//     $favouriteJoke->remove();
//     return response()->json(['success'=>'Deleted succesfully']);
// });
