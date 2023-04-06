{{-- CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Добавить фильм</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Название фильма</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="floors">Ссылка на постер для фильма</label>
                        <input type="text"
                            value="https://avatars.mds.yandex.net/get-kinopoisk-image/1946459/a0afcdb4-9155-4721-9ef0-c493c64b15e6/1920x"
                            name="image_link" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="year_of_construction">Дата премьеры</label>
                        <input name="premiere" type="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="year_of_construction">Кинозал</label><br>
                        @foreach ($halls as $hall)
                            <input type="checkbox" name="hall[]" class="btn-check" id="hall-id-{{ $hall->id }}"
                                value="{{ $hall->id }}" autocomplete="off">
                            <label class="btn btn-outline-success mt-2"
                                for="hall-id-{{ $hall->id }}">{{ $hall->name }}</label>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="year_of_construction ">Время показа</label><br>
                        @foreach ($times as $time)
                            <input type="checkbox" class="btn-check" name="time[]" id="time-id-{{ $time->id }}"
                                value="{{ $time->id }}" autocomplete="off">
                            <label class="btn btn-outline-primary mt-2"
                                for="time-id-{{ $time->id }}">{{ $time->time }}</label>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button type="button" id="create-submit" class="btn btn-primary"
                            data-bs-dismiss="modal">Добавить запись</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    </div>
                </form>
            </div>
            @yield('create-modal')
        </div>
    </div>
</div>
