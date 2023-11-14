<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
</head>
<body style="background-image: url('images/b2.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat; color: white;">
    <x-custom-header></x-custom-header>
    {{-- Baigiasi navigationas --}}
    <section class="wrapper">
        <div class="container-fostrap">
            <div class="content">
                <div class="container">
                    <!-- Add Bird Button -->
                    <button type="button" class="btn btn-primary lr-button register custom-button reg" data-bs-toggle="modal" data-bs-target="#addBirdModal">
                        Add Bird
                    </button>

                    <div class="modal fade" id="addBirdModal" tabindex="-1" aria-labelledby="addBirdModalLabel" aria-hidden="true" style="color: black;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBirdModalLabel">Add New Bird</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add your form fields here for adding new bird information -->
                                    <form action="your_php_script.php" method="post" enctype="multipart/form-data">
                                        <!-- Example input for bird name -->
                                        <div class="mb-3">
                                            <label for="birdName" class="form-label">Bird Name</label>
                                            <input type="text" class="form-control" name="birdName" id="birdName" placeholder="Enter bird name" required>
                                        </div>

                                        <!-- Add input for image -->
                                        <div class="mb-3">
                                            <label for="birdImage" class="form-label">Upload Bird Image</label>
                                            <input type="file" class="form-control" name="birdImage" id="birdImage" accept="image/*" required>
                                        </div>

                                        <!-- Add input for continent -->
                                        <div class="mb-3">
                                            <label for="birdContinent" class="form-label">Bird Continent</label>
                                            <input type="text" class="form-control" name="birdContinent" id="birdContinent" placeholder="Enter bird continent" required>
                                        </div>

                                        <!-- Add input for mini text -->
                                        <div class="mb-3">
                                            <label for="birdMiniText" class="form-label">Mini Text</label>
                                            <textarea class="form-control" name="birdMiniText" id="birdMiniText" rows="3" placeholder="Enter mini text about the bird" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Add Bird</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4">
                        <div class="card">
                            <a class="img-card" href="#">
                                <img src="{{ URL('images/bird9.png')}}" />
                            </a>
                            <div class=" card-content">
                                <h4 class="card-title">
                                    <a href="#"> Bird Name </a>
                                </h4>
                                <p class=""> Continent </p>
                                <p class=""> Text about bird </p>
                            </div>
                            <div class="card-read-more">
                                <a href="#" class="btn btn-danger btn-delete" data-action="delete">Delete</a>
                                <a href="#" class="btn btn-link btn-block"> View </a>
                                <a href="#" class="btn btn-warning btn-edit" data-action="edit">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<x-footer></x-footer>





</body>
</html>
