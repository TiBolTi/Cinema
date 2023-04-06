<div class="modal-body">
    <h1>{{ $movie->name }}</h1>
    <form id="form-seat" action="" method="POST">
        @csrf

        <input type="hidden" data-id-{{ $movie->id }} value="{{ $movie->id }}" name="movie_id">
        @foreach ($halls as $hall)
            <input type="radio" class="btn-check" value="{{ $hall->id }}" name="hall_id"
                id="show-hall-{{ $hall->id }}" autocomplete="off">
            <label class="btn btn-outline-success" for="show-hall-{{ $hall->id }}">{{ $hall->name }}</label>
        @endforeach
        <div id="time-buttons"></div>

        <div id="div-box"></div>

        @if (Auth::user())
            <button id="reserve" class="btn btn-success mt-2">Зарезервировать место</button>
        @endif
    </form>
</div>
<script>
    @foreach ($halls as $hall)
        $('#show-hall-{{ $hall->id }}').click(function() {

            let timeButtons = "<div id='time-buttons'>";

            @foreach ($times as $time)
                timeButtons +=
                    "<input type='radio' class='btn-check show-time' value='{{ $time->id }}'  name='time_id' id='show-time-{{ $time->id }}'>";
                timeButtons +=
                    "<label class='btn btn-outline-primary'  for='show-time-{{ $time->id }}'>{{ $time->time }}</label>"
            @endforeach

            timeButtons += "</div>";

            $('#time-buttons').html(timeButtons)

            @foreach ($times as $time)
                $('#show-time-{{ $time->id }}').click(function() {

                    $.ajax({
                        url: '{{ route('seat.show') }}',
                        type: 'GET',
                        data: $('#form-seat').serialize(),
                        success: function(response) {
                            console.log('success')
                            $('#div-box').html(response.seats_view);
                        },
                        fail: function(data) {
                            console.log('fail')
                            alert('Error')
                        }
                    })


                });
            @endforeach
        });
    @endforeach



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#reserve').click(function(e) {
        e.preventDefault();
        $('#reserve').prop('disabled', true);

        $.ajax({
            url: '{{ route('seat.reserve') }}',
            method: 'POST',
            data: $('#form-seat').serialize(),
            success: function(data) {
                console.log('success')
                $('#reserve').prop('disabled', false);
                $('#div-box').html(data.seats_view);

            },
            error: function(data) {
                console.log('fail')
                $('#reserve').prop('disabled', false);
            }
        });

    });
</script>
