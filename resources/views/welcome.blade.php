<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



    <title>Bird Encyclopedia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 36px;
        }

        nav {
            background-color: #2980b9;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            margin: 0 10px;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            text-align: center;
        }

        .bird-image {
            width: 100px;
            height: 100px;
            background: url('question-mark.jpg') no-repeat center center;
            background-size: cover;
        }

        .bird-description {
            margin: 10px 0;
        }

        .btn-transparent-white {
            background-color: transparent;
            color: #fff;

        }

        .btn-transparent-white:hover {
            color: #000;
        }

        .center-search {
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .small-search {
            width: 50%;
        }

        .logo {
            max-width: 50px;
            display: block;
            margin: 0;
        }

    </style>
</head>
<body>
    <header>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <img src="{{ URL('images/questionmark.png')}}" class="logo" style="width: 50px;">
            </div>
            <div class="mx-auto">
                <h1>Know Your Bird</h1>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn btn-transparent-white me-2" href="#">Login/Register</a>
                <img src="{{ URL('images/questionmark.png')}}" class="logo" style="width: 30px;">
            </div>
        </div>
        <div class="center-search">
            <div class="input-group small-search">
                <input type="text" class="form-control" placeholder="Search for birds">
                <button class="btn btn-primary" type="button">Search</button>
            </div>
        </div>
    </header>


    <nav>
        <a class="btn btn-transparent-white" href="#">Home</a>
        <a class="btn btn-transparent-white" href="#">Quizz</a>
        <div class="btn-group">
            <button type="button" class="btn btn-link btn btn-transparent-white dropdown-toggle" data-bs-toggle="dropdown">History</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Tablet</a>
                <a class="dropdown-item" href="#">Smartphone</a>
            </div>
        </div>
        <a class="btn btn-transparent-white" href="#">Bird list</a>
        <a class="btn btn-transparent-white" href="#">Bird forms</a>
    </nav>
    <div class="container">
        <h2>Welcome to the Bird Encyclopedia</h2>
        <h2>Lorem Ipsum</h2>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <div class="container">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" style="height: 200px;  overflow: hidden; border: 2px solid #000; width: 100%; margin: 0 auto;">
            <div class="carousel-inner" style="height: 100%;">
                <div class="carousel-item active" style="height: 100%;">
                    <img src="{{ URL('images/questionmark.png')}}" class="d-block w-100 h-100" alt="Image 1">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/questionmark.png')}}" class="d-block w-100 h-100" alt="Image 2">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" style="height: 100%;">
                    <img src="{{ URL('images/questionmark.png')}}" class="d-block w-100 h-100" alt="Image 3">
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


    <main class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-20">
                    <img src="{{ URL('images/questionmark.png')}}" alt="Image" style="float: right; width: 400px; height: 400px;">
                    <p class="fs-3">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>

                    <p class="fs-3">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>
        </div>
    </main>
    </section>

    <div class="container">
        <div class="row">
            <div class="col text-center" style="background-color: #2980b9;">
                <br>
                <p style="color: white;"> © 2023 Know Your Bird. All rights reserved.</p>
            
            <div class="row">
                <div class="col text-center" style="background-color: #2980b9;">
                    <a href="#" class="btn btn-transparent-white">About</a>
                    <a href="#" class="btn btn-transparent-white">Facebook</a>
                    <a href="#" class="btn btn-transparent-white">Social Media</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
