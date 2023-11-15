<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
</head>

<body style="background-image: url('images/b2.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat; color: white;">
    <x-custom-header></x-custom-header>
    
    <div class="container">
        <div class="image-container" style="background-image: url('images/1200.jpg');">
            <h2>Welcome to the Bird Encyclopedia</h2>
            <h2>Lorem Ipsum</h2>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 

    <div class="container">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" style="height: 300px; overflow: hidden; border: 2px solid #000; width: 100%; margin: 0 auto;">
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
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>



     position: sticky;
    top: 20px;
<x-footer></x-footer>
</body>
</html>
