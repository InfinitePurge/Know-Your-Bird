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
                <button type="submit" class="btn btn-primary lr-button login btn-lg">Logout</button>
            </form>

            <x-dropdown-link href="{{ route('profile.show') }}" class="btn btn-primary lr-button register">
                <span class="profile-text">{{ __('Profile') }}</span>
                <img src="images/usericon.png" alt="Profile Icon" class="btn-icon" width="30" height="30">
            </x-dropdown-link>


            {{-- <a class="btn btn-primary ml-lg-3" href="{{route('profile')}}">Profile</a> --}}

            @else

            <a class="btn btn-primary lr-button login" href="{{route('login')}}">Login</a>

            <a class="btn btn-primary lr-button register" href="{{route('register')}}">Register</a>

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