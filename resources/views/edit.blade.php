

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Редактировать фильм</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" action="" method="POST">
                    @csrf
                    <input type="hidden" data-id-{{ $movie->id }} value="{{ $movie->id }}" name="movie_id">
                    <div class="form-group">
                        <label for="name">Название фильма</label>
                        <input type="text" value="{{$movie->name}}" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="floors">Ссылка на постер для фильма</label>
                        <input type="text"
                               value="{{$movie->image_link}}"
                               name="image_link" class="form-control">
                    </div>

                    <div class="form-group">

                        <label for="year_of_construction">Дата премьеры</label>
                        <input value="{{$movie->premiere}}" name="premiere" type="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="year_of_construction">Кинозал</label><br>
                        @foreach ($halls as $hall)
                            <input type="checkbox" name="hall[]" class="btn-check" id="hall-id-{{ $hall->id }}"
                                   value="{{ $hall->id }}" autocomplete="off">
                            <label class="btn btn-success mt-2"
                                   for="hall-id-{{ $hall->id }}">{{ $hall->name }}</label>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="year_of_construction ">Время показа</label><br>
                        @foreach ($times as $time)
                            <input type="checkbox" class="btn-check" name="time[]" id="time-id-{{ $time->id }}"
                                   value="{{ $time->id }}" autocomplete="off">
                            <label class="btn btn-primary mt-2"
                                   for="time-id-{{ $time->id }}">{{ $time->time }}</label>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button type="button" id="movie-update-button" class="btn btn-primary"
                                data-bs-dismiss="modal">Обновить запись</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    </div>
                </form>
            </div>
        </div>



<script>
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $('#movie-update-button').click(function(e) {

        e.preventDefault();
        $('#movie-update-button').prop('disabled', true);
        $.ajax({
        url: '{{ route('movie.update') }}',
        method: 'POST',
        data: $('#edit-form').serialize(),
        success: function(data) {
        console.log('success')
        $('#movie-update-button').prop('disabled', false);
        $('#showModal').before(data.view);
        $('#form')[0].reset();
        },
        error: function(data) {
        console.log('fail')
        $('#create-submit').prop('disabled', false);
        }
        });
        });
        </script>

