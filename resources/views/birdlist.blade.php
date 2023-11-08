<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
</head>
<body>
    <x-custom-header></x-custom-header>
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
