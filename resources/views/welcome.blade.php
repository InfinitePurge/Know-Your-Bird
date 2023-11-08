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
            @if(Route::has('login'))
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>

            <x-dropdown-link href="{{ route('profile.show') }}">
                {{ __('Profile') }}
            </x-dropdown-link>

            {{-- <a class="btn btn-primary ml-lg-3" href="{{route('profile')}}">Profile</a> --}}

            @else

            <a class="btn btn-primary ml-lg-3" href="{{route('login')}}">Login</a>

            <a class="btn btn-primary ml-lg-3" href="{{route('register')}}">Register</a>

            @endauth
            @endif
        </div>
        <div class="center-search">
            <div class="input-group small-search">
                <input type="text" class="form-control" placeholder="Search for birds">
                <button class="btn btn-primary search-button" type="button">Search</button>
            </div>
        </div>


    </header>


    <nav>
        <a class="btn btn-transparent-white" href="/">Dashboard</a>
        <a class="btn btn-transparent-white" href="#">Quizz</a>
        <div class="btn-group">
            <button type="button" class="btn btn-link btn btn-transparent-white dropdown-toggle"
                data-bs-toggle="dropdown">History</button>
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
            <button type="button" class="btn btn-link btn btn-transparent-white dropdown-toggle"
                data-bs-toggle="dropdown">Bird forms</button>
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
    <div class="container">
        <div class="image-container" style="background-image: url('images/1200.jpg');">
            <h2>Welcome to the Bird Encyclopedia</h2>
            <h2>Lorem Ipsum</h2>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <div class="container">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel"
            style="height: 300px; overflow: hidden; border: 2px solid #000; width: 100%; margin: 0 auto;">
            <div class="carousel-inner" style="height: 100%;">
                <div class="carousel-item active" style="height: 100%;">
                    <img src="{{ URL('images/bird4.jpg')}}" class="d-block w-100 h-100 object-fit-cover" alt="Image 1">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/bird3.jpg')}}" class="d-block w-100 h-100 object-fit-cover" alt="Image 2">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/1200.jpg')}}" class="d-block w-100 h-100 object-fit-cover" alt="Image 3">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/bird6.jpg')}}" class="d-block w-100 h-100 object-fit-cover" alt="Image 3">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/bird8.jpg')}}" class="d-block w-100 h-100 object-fit-cover" alt="Image 3">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>



    <main class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-20">
                    <div class="title-container">
                        <div class="stripe"></div>
                        <h2 class="title-text">Recent News About Birds</h2>
                        <div class="stripe"></div>

                    </div>
                    <div class="left-aligned-text">
                        <br>
                        <br>
                        <img src="{{ URL('images/bird7.avif')}}" alt="Image"
                            style="float: right; width: 400px; height: 400px;">
                        <p class="fs-3">

                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>

                        <p class="fs-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        <p class="fs-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p class="fs-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </section>

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

</body>

</html>