@extends('layouts.app')

@section('content')
    @extends('layouts.modal')
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body " id="showModal">
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">

        @foreach ($movies as $movie)
            <form id="movie-{{$movie->id}}" method="get">
                @csrf
            <div class="col">
                <div class="card">
                    <img src="{{ $movie->image_link }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->name }}</h5>
                        <p class="card-text">Примьера: {{ $movie->premiere }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#Modal"
                                class="btn btn-primary movie-button" data-id="{{ $movie->id }}">Места в кинотеатре</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#Modal"
                               class="btn btn-success movie-show-button" data-id="{{ $movie->id }}">Show</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#Modal"
                               class="btn btn-success movie-edit-button" data-id="{{ $movie->id }}">Edit</a>
                        </div>
                    </div>

                </div>

            </div>
            </form>
        @endforeach


        <div id="create-card" class="card border-success ms-3" style="max-width: 21rem;">
            <div class="card-body d-flex flex-column justify-content-center align-content-center text-success">
                <button class="btn btn-success" id="create-film" data-bs-toggle="modal" data-bs-target="#createModal">
                    Добавить фильм
                </button>
            </div>
        </div>
    </div>
    <br>


    <script>




        $('.movie-edit-button').click(function() {
            // let id = $(this).data('id')
            let id = $(this).data('id');


            $.ajax({
                url: '{{ route('movie.edit') }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log('success')
                    $('#showModal').html(response.view);


                },
                fail: function(data) {
                    console.log('fail')
                    alert('Error')
                }
            })
        })

        $('.movie-show-button').click(function() {
            // let id = $(this).data('id')
            let id = $(this).data('id');


            $.ajax({
                url: '{{ route('movie.show') }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log('success')
                    $('#showModal').html(response.view);


                },
                fail: function(data) {
                    console.log('fail')
                    alert('Error')
                }
            })
        })

        $('.movie-button').click(function() {
            // let id = $(this).data('id')
            let id = $(this).data('id');


            $.ajax({
                url: '{{ route('seat.index') }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log('success')
                    $('#showModal').html(response.view);


                },
                fail: function(data) {
                    console.log('fail')
                    alert('Error')
                }
            })
        })


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#create-submit').click(function(e) {

            e.preventDefault();
            $('#create-submit').prop('disabled', true);
            $.ajax({
                url: '{{ route('movie.create') }}',
                method: 'POST',
                data: $('#form').serialize(),
                success: function(data) {
                    console.log('success')
                    $('#create-submit').prop('disabled', false);
                    $('#create-card').before(data.record);
                    $('#form')[0].reset();
                },
                error: function(data) {
                    alert('error')
                    console.log('fail')
                    $('#create-submit').prop('disabled', false);
                }
            });
        });

    </script>
@endsection
