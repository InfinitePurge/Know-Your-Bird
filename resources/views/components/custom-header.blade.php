<header style="background: linear-gradient(90deg, rgba(0,0,0,0.8869922969187675) 20%, rgba(3,177,177,1) 100%); position: relative; padding-right: 15px; padding-left: 15px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <a href="/">
                    <img src="{{ URL('images/birdlogo.png')}}" class="logo" style="width: 100%; height: 100%">
                </a>
            </div>
            <div class="col text-center">
                <h1 style="white-space: nowrap; margin: 0;">Know Your Bird</h1>
            </div>
            <div class="col text-right">
                @if(Route::has('login'))
                @auth
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary lr-button register custom-button reg">Logout</button>
                </form>

                    <a class="btn btn-primary lr-button login custom-button log" href="{{ route('profile.show') }}">Profile</a>


                @else
                <a class="btn btn-primary lr-button login custom-button log" href="{{ route('login') }}">Login</a>
                <a class="btn btn-primary lr-button register custom-button reg" href="{{ route('register') }}">Register</a>
                @endauth
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <form action="{{ route('birdlist.search') }}" method="GET" class="mb-3 d-flex justify-content-center">
            <div class="input-group" style="max-width: 60%;">
                <input type="text" class="form-control" placeholder="Search for birds" name="search">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
</header>


<nav>
    <a class="btn btn-transparent-white" href="/">Home</a>
    <a class="btn btn-transparent-white" href="#">Quizz</a>
    <div class="btn-group">
        <button type="button" class="btn btn-link btn btn-transparent-white dropdown-toggle" data-bs-toggle="dropdown">History</button>
        <div class="dropdown-menu DropDownDesignForNav">
            <a class="dropdown-item DropDownText" href="/history#History">History</a>
            <a class="dropdown-item DropDownText" href="/history#Flight">Flight</a>
            <a class="dropdown-item DropDownText" href="/history#Flightlessness">Flightlessness</a>
            <a class="dropdown-item DropDownText" href="/history#Walking and hopping">Walking and hopping</a>
            <a class="dropdown-item DropDownText" href="/history#Swimming and diving">Swimming and diving</a>
            <a class="dropdown-item DropDownText" href="/history#Sound">Sound</a>
            <a class="dropdown-item DropDownText" href="/history#Nesting">Nesting</a>
            <a class="dropdown-item DropDownText" href="/history#Feeding habits">Feeding habits</a>
        </div>
    </div>
    <a class="btn btn-transparent-white" href="/birdlist">Bird list</a>
    <div class="btn-group">
        <button type="button" class="btn btn-link btn btn-transparent-white dropdown-toggle" data-bs-toggle="dropdown">Bird forms</button>
        <div class="dropdown-menu DropDownDesignForNav">
            <a class="dropdown-item DropDownText" href="/birdforms#Bird Forms">Bird Forms</a>
            <a class="dropdown-item DropDownText" href="/birdforms#Feathers">Feathers</a>
            <a class="dropdown-item DropDownText" href="/birdforms#Molting">Molting</a>
            <a class="dropdown-item DropDownText" href="/birdforms#Colour">Colour</a>
            <a class="dropdown-item DropDownText" href="/birdforms#Other external features">Other external features</a>
            <a class="dropdown-item DropDownText" href="/birdforms#Skeleton">Skeleton</a>
            <a class="dropdown-item DropDownText" href="/birdforms#Muscles and organs">Muscles and organs</a>
        </div>
    </div>
</nav>
