<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
</head>

<body
    style="background-image: url('images/b2.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
    <x-custom-header></x-custom-header>
    <script src="{{ asset('jasonas/loading.js') }}"></script>

    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="container">
        <div class="image-container" style="background-image: url('images/birds/bird11.jpg');">
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
                    <img src="{{ URL('images/birds/bird4.jpg')}}"
                        class="d-block w-100 h-100 object-fit-cover" alt="Image 1">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/birds/bird3.jpg')}}"
                        class="d-block w-100 h-100 object-fit-cover" alt="Image 2">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/birds/bird11.jpg')}}"
                        class="d-block w-100 h-100 object-fit-cover" alt="Image 3">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/birds/bird6.jpg')}}"
                        class="d-block w-100 h-100 object-fit-cover" alt="Image 3">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/birds/bird8.jpg')}}"
                        class="d-block w-100 h-100 object-fit-cover" alt="Image 3">
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



    <main class="mb-4" style="color: white;">
        <div class="container px-4 px-lg-5" style="background: linear-gradient(90deg, rgba(0,0,0,0.8869922969187675) 20%, rgba(3,177,177,1) 100%);">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-8">
                    <div class="title-container text-center">
                        <div class="stripe"></div>
                        <h2 class="title-text">Recent News About Birds</h2>
                        <div class="stripe"></div>
                    </div>
                    <div class="left-aligned-text">
                        <br>
                        <br>
                        <img src="{{ URL('images/birds/bird7.avif')}}" alt="Image" class="img-fluid rounded float-md-end"
                            style="max-width: 400px; height: auto;">
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
    <x-footer></x-footer>
</body>

</html>