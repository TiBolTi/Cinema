<div id='div-box' class='d-flex flex-column mt-5 container'>
    @for ($i = $hall->rows_number; $i >= 1; $i--)
        <div id='hall-{{ $hall_id }}' value='{{ $hall_id }}' class='d-flex'>
            <p class='me-5' style='width: 50px;'>Ряд {{ $i }}</p>

            @for ($j = $hall->number_seats_row; $j >= 1; $j--)
                @php
                    $isReserved = false;
                    $reserved_seats = \App\Models\ReservedSeat::all();
                    
                    $user_id = 0;
                    if (Auth::user()) {
                        $user = Auth::user();
                        $user_id = $user->id;
                    }
                    
                    foreach ($reserved_seats as $seat) {
                        if ($seat->reserved_seat == $i . '-' . $j && $seat->seance_id == $reserve) {
                            $isReserved = true;
                    
                            $ticket = $seat->ticket_id;
                            $ticket = \App\Models\Ticket::find($ticket);
                            if ($ticket != null) {
                                $ticket_id = $ticket->user_id;
                            }
                    
                            break;
                        }
                    }
                @endphp

                @if ($isReserved)
                    @if ($ticket != null)
                        @if ($ticket_id == $user_id)
                            <a class='btn btn-success available-seat' for='{{ $i }}-{{ $j }}'
                                data-seat='{{ $i }}-{{ $j }}'>{{ $j }}</a><br>
                        @else
                            <a class='btn btn-secondary available-seat' for='{{ $i }}-{{ $j }}'
                                data-seat='{{ $i }}-{{ $j }}'>{{ $j }}</a><br>
                        @endif
                    @endif
                @else
                    <input type='checkbox' value='{{ $i }}-{{ $j }}' name='reserved_seat[]'
                        class='btn-check reserved-seat' id='{{ $i }}-{{ $j }}'>
                    <label class='btn btn-outline-primary reserved-seat-label'
                        for='{{ $i }}-{{ $j }}'>{{ $j }}</label><br>
                @endif
            @endfor
        </div>
    @endfor
</div>
