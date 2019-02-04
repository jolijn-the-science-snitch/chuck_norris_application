<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Chuck Norris</title>

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet"> 

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Roboto', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            #joke {
                padding: 0 15%;
            }

            #jokeList {
                text-align: left;
                padding: 0 10%;
            }

            h1 {
                font-size: 70px;
            }

            h2 {
                font-size: 50px;
            }

            p {
                font-size: 25px;
            }

            span {
                font-size: 20px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            label {
            font-size: 48px;
            margin-bottom: 1.2rem;
            }

            label input[type="checkbox"] {
            display: none;
            }

            .custom-checkbox {
            margin-left: 0.5em;
            position: relative;
            cursor: pointer;
            }

            .custom-checkbox .checkFavorite {
            color: gold;
            position: absolute;
            font-size: 0.75em;
            }

            .checkRemove {
                color: #b30000;
                position: absolute;
                font-size: 0.5em;
            }

            .custom-checkbox .fa-star-o {
            color: gray;
            }

            .custom-checkbox .fa-star {
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            }

            .custom-checkbox:hover .fa-star {
            opacity: 0.5;
            }

            .custom-checkbox input[type="checkbox"]:checked ~ .fa-star {
            opacity: 1;
            }
        </style>
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <h1>The Chuck Norris application</h1>
                    <p id="joke">Press the button to load in a joke.</p><br />
                    <button type="button" class="btn btn-primary">Load a new joke</button>
                    <span class="favorite"></span>
                </div>
            </div>
        </div>
        <hr>
        <div class="flex-center position-ref">
            <div class="content">
                <div class="title m-b-md">
                    <h2>Your favorite jokes</h2>
                    <ul id="jokeList"></ul>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.btn-primary').click(function() {
                    $('#joke').text('Loading a new joke...');
                    $.ajax({
                        type:'GET',
                        url:'https://api.icndb.com/jokes/random',
                        success: function(data) {
                            $('#joke').html(JSON.stringify(data.value.joke))
                            $('.favorite')
                                .empty()
                                .append($('<label for="addToFavorites" class="custom-checkbox"></label>').html('<i class="checkFavorite fa fa-star-o"></i><i class="checkFavorite fa fa-star"></i>')
                                .append($('<input type="checkbox" value="'+ data.value.id +'" id="addToFavorites" id="addFavorite"/>').on('click', function(e) {
                                    $('#jokeList')
                                    .append($('<li class="jokeItem joke-'+ data.value.id +'" name="jokeId"></li>').html('<p name="jokeText" class="jokeText" id="jokeText">'+ data.value.joke +'</p>'))
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        method: 'post',
                                        url: "{{ url('/favouritejokes/save') }}",
                                        data: {
                                            'joke_id': data.value.id,
                                            'joke_text': data.value.joke,
                                        }
                                    });
                                    $('<label for="removeFromFavorites" class="custom-checkbox"></label>').html('<i class="checkRemove fa fa-trash-o"></i>').appendTo('.joke-'+ data.value.id +' .jokeText')   
                                    .append($('<input type="checkbox" value="'+ data.value.id +'" class="deleteJoke" id="removeFromFavorites" data-id="'+ data.value.id +'"/>'). on('click', function() {
                                        deleteJoke(data.value.id);
                                    }));
                                })));
                        },
                        error: function (data) {
                            alert('Whoops, something went wrong');
                        },
                        dataType: 'json',
                    });
                });

                function deleteJoke(joke_id) {
                    $.ajax({
                        url: "{{ url('/favouritejokes/delete') }}",
                        method: 'post',
                        data: {
                            "joke_id": joke_id,
                        },
                        success: function (){
                            $('.joke-'+ joke_id +'').remove();
                            alert('You have removed one of your favorite jokes... You have to refresh the page to start liking new ones again. (All other saved jokes will be lost too)');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
