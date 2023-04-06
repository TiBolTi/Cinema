<?php

namespace App\Http\Controllers;

use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\MovieSeance;
use App\Models\ReservedSeat;
use App\Models\Ticket;
use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeatReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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



        $view = view('movie', compact('movie', 'halls', 'times'))->render();

        return response()->json(['view' => $view]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reserve(Request $request)
    {
        $seance_data = $request->only('movie_id', 'hall_id', 'time_id');
        $seats = $request->input('reserved_seat');


        $user = Auth::user();
        $user_id = $user->id;

        $seance_id = MovieSeance::select('id')
            ->where('movie_id', '=', $seance_data['movie_id'])
            ->where('hall_id', '=', $seance_data['hall_id'])
            ->where('time_id', '=', $seance_data['time_id'])
            ->value('id');


        $ticket_data = [
            'user_id' => $user_id,
        ];
        $ticket = new Ticket($ticket_data);

        $ticket->save();

        $ticket = Ticket::latest()->take(1)->first();

        foreach ($seats as $seat) {
            $res_seat = [
                'ticket_id' => $ticket->id,
                'seance_id' => $seance_id,
                'reserved_seat' => $seat,
            ];
            $reserved_seats = new ReservedSeat($res_seat);
            $reserved_seats->save();
        }

        $hall_id = $request->hall_id;

        $seance_id = MovieSeance::select('id')
            ->where('movie_id', '=', $request->movie_id)
            ->where('hall_id', '=', $hall_id)
            ->where('time_id', '=', $request->time_id)
            ->value('id');

        $reserve = ReservedSeat::select('seance_id')
            ->where('seance_id', '=', $seance_id)
            ->value('seance_id');

        $time_id = $request->time_id;
        $hall = CinemaHall::select()
            ->where('id', '=', $hall_id)
            ->first();


        $seats_view = view('seats', compact('hall_id', 'hall', 'time_id',  'reserve'))->render();


        return response()->json(['seats_view' => $seats_view]);
    }


//        dd($request, $user_id);

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $hall_id = $request->hall_id;

        $seance_id = MovieSeance::select('id')
            ->where('movie_id', '=', $request->movie_id)
            ->where('hall_id', '=', $hall_id)
            ->where('time_id', '=', $request->time_id)
            ->value('id');

        $reserve = ReservedSeat::select('seance_id')
            ->where('seance_id', '=', $seance_id)
            ->value('seance_id');

        $time_id = $request->time_id;
        $hall = CinemaHall::select()
            ->where('id', '=', $hall_id)
            ->first();


        $seats_view = view('seats', compact('hall_id', 'hall', 'time_id',  'reserve'))->render();


        return response()->json(['seats_view' => $seats_view]);





    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
