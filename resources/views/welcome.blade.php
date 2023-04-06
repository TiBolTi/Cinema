@extends('layouts.app')

@section('content')
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
            <div class="col">
                <div class="card">
                    <img src="{{ $movie->image_link }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->name }}</h5>
                        <p class="card-text">Примьера: {{ $movie->premiere }}</p>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#Modal"
                            class="btn btn-primary movie-button" data-id="{{ $movie->id }}">Button</a>
                    </div>
                </div>
            </div>
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
        $('.movie-button').click(function() {
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
    </script>

@section('create-modal')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#create-submit').click(function(e) {

            e.preventDefault();
            $('#create-submit').prop('disabled', true);
            $.ajax({
                url: '{{ route('create') }}',
                method: 'POST',
                data: $('#form').serialize(),
                success: function(data) {
                    console.log('success')
                    $('#create-submit').prop('disabled', false);
                    $('#create-card').before(data.record);
                    $('#form')[0].reset();
                },
                fail: function(data) {
                    alert('errpr')
                    console.log('fail')
                    $('#create-submit').prop('disabled', false);
                }
            });
        });
    </script>
@endsection

@section('delete-modal')
    <script>
        $('#Modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var table = button.data('table');
            var id = button.data('id');
            var form = $(this).find('form');
            var actionUrl = "{{ url('/') }}/" + table + "/" + id;
            form.attr('action', actionUrl);
        });
    </script>
@endsection


@endsection
