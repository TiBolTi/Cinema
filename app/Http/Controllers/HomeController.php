<?php

namespace App\Http\Controllers;

use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\MovieSeance;
use App\Models\Time;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seance = MovieSeance::all();
        $movies = Movie::all();
        $times = Time::all();
        $halls = CinemaHall::all();

        return view('home', compact('movies', 'halls', 'times', 'seance'));
    }
}
