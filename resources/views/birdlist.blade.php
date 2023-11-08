<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <img src="{{ URL('images/birdlogo.png')}}" class="logo" style="width: 300px; height: 60px;">
            </div>
            <div class="mx-auto">
                <h1>Know Your Bird</h1>
            </div>
        </div>
        <div class="center-search">
            <div class="input-group small-search">
                <input type="text" class="form-control" placeholder="Search for birds">
                <button class="btn btn-primary search-button" type="button">Search</button>
            </div>
        </div>
    </header>
    <nav>
        <a class="btn btn-transparent-white" href="/">Home</a>
        <a class="btn btn-transparent-white" href="#">Quizz</a>
        <div class="btn-group">
            <button type="button" class="btn btn-link btn btn-transparent-white dropdown-toggle" data-bs-toggle="dropdown">History</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Flight</a>
                <a class="dropdown-item" href="#">Flightlessness</a>
                <a class="dropdown-item" href="#">Walking and hopping</a>
                <a class="dropdown-item" href="#">Swimming and diving</a>
                <a class="dropdown-item" href="#">Sound</a>
                <a class="dropdown-item" href="#">Nesting</a>
                <a class="dropdown-item" href="#">Feeding habits</a>
            </div>
        </div>
        <a class="btn btn-transparent-white" href="/birdlist">Bird list</a>
        <div class="btn-group">
            <button type="button" class="btn btn-link btn btn-transparent-white dropdown-toggle" data-bs-toggle="dropdown">Bird forms</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Feathers</a>
                <a class="dropdown-item" href="#">Molting</a>
                <a class="dropdown-item" href="#">Colour</a>
                <a class="dropdown-item" href="#">Other external features</a>
                <a class="dropdown-item" href="#">Skeleton</a>
                <a class="dropdown-item" href="#">Muscles and organs</a>
            </div>
        </div>
    </nav>
    {{-- Baigiasi navigationas --}}
    <section class="wrapper">
        <div class="container-fostrap">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="card">
                                <a class="img-card" href="#">
                                    <img src="{{ URL('images/bird9.png')}}" />
                                </a>
                                <div class="card-content">
                                    <h4 class="card-title">
                                        <a href="#"> Bird Name
                                        </a>
                                    </h4>
                                    <p class="">
                                        Text about bird
                                    </p>
                                </div>
                                <div class="card-read-more">
                                    <a href="#" class="btn btn-link btn-block">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="card">
                                <a class="img-card" href="#">
                                    <img src="{{ URL('images/bird9.png')}}" />
                                </a>
                                <div class="card-content">
                                    <h4 class="card-title">
                                        <a href="#"> Bird Name
                                        </a>
                                    </h4>
                                    <p class="">
                                        Text about bird
                                    </p>
                                </div>
                                <div class="card-read-more">
                                    <a href="#" class="btn btn-link btn-block">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="card">
                                <a class="img-card" href="#">
                                    <img src="{{ URL('images/bird9.png')}}"" />
                                </a>
                                <div class=" card-content">
                                    <h4 class="card-title">
                                        <a href="#"> Bird Name
                                        </a>
                                    </h4>
                                    <p class="">
                                        Text about bird
                                    </p>
                            </div>
                            <div class="card-read-more">
                                <a href="#" class="btn btn-link btn-block">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        {{-- Pakartotinis apacioje --}}
        <section class="wrapper">
            <div class="container-fostrap">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="card">
                                    <a class="img-card" href="{{ URL('images/bird9.png')}}">
                                        <img src="{{ URL('images/bird9.png')}}" />
                                    </a>
                                    <div class="card-content">
                                        <h4 class="card-title">
                                            <a href="#">
                                                Bird Name
                                            </a>
                                        </h4>
                                        <p class="">
                                            Text about bird
                                        </p>
                                    </div>
                                    <div class="card-read-more">
                                        <a href="#" class="btn btn-link btn-block">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="card">
                                    <a class="img-card" href="#">
                                        <img src="{{ URL('images/bird9.png')}}" />
                                    </a>
                                    <div class="card-content">
                                        <h4 class="card-title">
                                            <a href="#">
                                                Bird Name
                                            </a>
                                        </h4>
                                        <p class="">
                                            Text about bird
                                        </p>
                                    </div>
                                    <div class="card-read-more">
                                        <a href="#" class="btn btn-link btn-block">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="card">
                                    <a class="img-card" href=#">
                                        <img src="{{ URL('images/bird9.png')}}" />
                                    </a>
                                    <div class="card-content">
                                        <h4 class="card-title">
                                            <a href="#">
                                                Bird Name
                                            </a>
                                        </h4>
                                        <p class="">
                                            text about bird
                                        </p>
                                    </div>
                                    <div class="card-read-more">
                                        <a href="#" class="btn btn-link btn-block">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Uzsibaigia kortos --}}


            <div class="container">
                <div class="row">
                    <div class="col text-center" style="background-color: #687EFF;">
                        <br>
                        <p style="color: white;"> © 2023 Know Your Bird. All rights reserved.</p>

                        <div class="row">
                            <div class="col text-center" style="background-color: #687EFF;">
                                <a href="#" class="btn btn-transparent-white">About</a>
                                <a href="#" class="btn btn-transparent-white">Facebook</a>
                                <a href="#" class="btn btn-transparent-white">Social Media</a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>





</body>
</html>
