<?php

namespace App\Http\Controllers;

use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\MovieSeance;
use App\Models\ReservedSeat;
use App\Models\Ticket;
use App\Models\Time;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;
use function Sodium\add;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seances = MovieSeance::all();
        $movies = Movie::all();
        $times = Time::all();
        $halls = CinemaHall::all();

        return view('home', compact('movies', 'halls', 'times', 'seances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $film_data = $request->only('name', 'image_link', 'premiere');
        $film = Movie::create($film_data);

        $halls = $request->input('hall');
        $times = $request->input('time');

        foreach ($halls as $hall) {
            foreach ($times as $time) {
                $seanse_data = [
                    'movie_id' => $film->id,
                    'hall_id' => $hall,
                    'time_id' => $time,
                ];
                $seanse = new MovieSeance($seanse_data);
                    $seanse->save();
            }
        }
        $movie = Movie::latest()->take(1)->first();
        $film_card = [
                   " <div class='col' >
            <div class='card'>
                <img src='".$movie->image_link."' class='card-img-top' alt='...'>
                <div class='card-body'>
                    <h5 class='card-title'>".$movie->name."</h5>
                    <p class='card-text'>Примьера: ".$movie->premiere."</p>
                    <a href='#' class='btn btn-primary'>Button</a>
                </div>

            </div>

        </div>"
        ];
        return  response()->json(['record' => $film_card]);
//        dd($film, $halls, $times);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $movie = Movie::find($request->id);

        $film_card = [
            "
             <div class='modal-header'>
                <h5 class='modal-title' id='deleteModalLabel'>Информация о фильме</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
            <div class='card d-flex flex-row'>
                <img src='".$movie->image_link."' width='200px' class='img-thumbnail' alt='...'>
                <div class='card-body'>
                    <h2 class='card-title'>".$movie->name."</h2>
                    <p class='card-text'>Примьера: ".$movie->premiere."</p>
                </div>

            </div>

        </div>
     "
        ];
        return  response()->json(['view' => $film_card]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $movie = Movie::find($request->id);

        $seance = MovieSeance::select('movie_id')
            ->where('movie_id', '=', $movie->id)
            ->first();

        $halls_id = MovieSeance::select('hall_id')
            ->where('movie_id', '=', $movie->id)
            ->groupBy('hall_id')
            ->get();

        $halls = collect();
        foreach ($halls_id as $hall_id) {
            $hall = CinemaHall::find($hall_id->hall_id);
            if ($hall) {
                $halls->push($hall);
            }
        }

        $times_id = MovieSeance::select('time_id')
            ->where('movie_id', '=', $movie->id)
            ->groupBy('time_id')
            ->get();

        $times = collect();
        foreach ($times_id as $time_id) {
            $time = Time::find($time_id->time_id);
            if ($time) {
                $times->push($time);
            }
        }

        $view = view('edit', compact('movie', 'halls', 'times'))->render();

        return response()->json(['view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
//        $movie->update($request->all());
//        dd($request);
//        $movie->save();

//        $view = view('edit', compact('movie'))->render();
//
//        return response()->json(['view' => $view]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
