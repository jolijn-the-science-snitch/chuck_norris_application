<?php

namespace App\Http\Controllers;

use App\FavouriteJokes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavouriteJokesController extends Controller
{
    public function store(Request $request) {
        $favouriteJoke = new FavouriteJokes;

        $favouriteJoke->joke_id = $request->joke_id;
        $favouriteJoke->joke_text = $request->joke_text;
        $favouriteJoke->visitor = \Request::ip();
        
        $favouriteJoke->save();
    }

    public function delete($id) {
        FavouriteJokes::find($id)->delete($id);
    }
}
