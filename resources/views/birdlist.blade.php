<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
    <link href="{{ asset('jasonas/jasonas.js') }}" rel="stylesheet">
</head>

<body
    style="background-image: url('images/b2.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat; color: white;">
    <x-custom-header></x-custom-header>

    <section class="wrapper">
        <div class="container-fostrap">
            <div class="content">
                <div class="container" style="color:black">
                    <!-- Add Bird Button -->
                    @if(auth()->check() && auth()->user()->role == 1)
                    <button type="button" class="btn btn-primary lr-button register custom-button reg"
                        data-bs-toggle="modal" data-bs-target="#addBirdModal">
                        Add Bird
                    </button>
                    @endif

                    <div class="modal fade" id="addBirdModal" tabindex="-1" aria-labelledby="addBirdModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBirdModalLabel">Add New Bird</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add your form fields here for adding new bird information -->
                                    <form action="your_php_script.php" method="post" enctype="multipart/form-data">
                                        <!-- Example input for bird name -->
                                        <div class="mb-3">
                                            <label for="birdName" class="form-label">Bird Name</label>
                                            <input type="text" class="form-control" name="birdName" id="birdName"
                                                placeholder="Enter bird name" required>
                                        </div>

                                        <!-- Add input for image -->
                                        <div class="mb-3">
                                            <label for="birdImage" class="form-label">Upload Bird Image</label>
                                            <input type="file" class="form-control" name="birdImage" id="birdImage"
                                                accept="image/*" required>
                                        </div>

                                        <!-- Add input for continent -->
                                        <div class="mb-3">
                                            <label for="birdContinent" class="form-label">Bird Continent</label>
                                            <input type="text" class="form-control" name="birdContinent"
                                                id="birdContinent" placeholder="Enter bird continent" required>
                                        </div>

                                        <!-- Add input for mini text -->
                                        <div class="mb-3">
                                            <label for="birdMiniText" class="form-label">Mini Text</label>
                                            <textarea class="form-control" name="birdMiniText" id="birdMiniText"
                                                rows="3" placeholder="Enter mini text about the bird"
                                                required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Add Bird</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
    </section>
    <!-- Bird Cards -->
    <section class="wrapper">
        <div class="container-fostrap">
            <div class="content">
                <div class="container">
                    <div class="row">
                        @foreach($birds as $bird)
                        <div class="col-xs-12 col-sm-4">
                            <div class="card">
                                <a class="img-card" href="#">
                                    <img src="{{ asset('images/birds/' . basename($bird->image)) }}"
                                        alt="{{ $bird->pavadinimas }}" />
                                </a>
                                <div class="card-content">
                                    <h4 class="card-title">
                                        <a href="#"> {{ $bird->pavadinimas }} </a>
                                    </h4>
                                    <p class=""> {{ $bird->kilme }} </p>
                                    <p class="text-overflow-clamp"> {{ $bird->aprasymas }} </p>
                                </div>
                                <div class="card-read-more">
                                    <!-- Add your buttons for delete, view, and edit here -->
                                    @if(auth()->check() && auth()->user()->role == 1)
                                    <a href="#" class="btn btn-danger btn-delete" data-action="delete">Delete</a>
                                    @endif
                                    <a href="{{ route('bird.view', ['pavadinimas' => $bird->pavadinimas]) }}">View</a>
                                    @if(auth()->check() && auth()->user()->role == 1)
                                    <a href="#" class="btn btn-warning btn-edit" data-action="edit">Edit</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="pagination">
                        @if ($birds->currentPage() > 1)
                        <a href="{{ $birds->previousPageUrl() }}" rel="prev">&lt;</a>
                        @else
                        <span class="disabled">&lt;</span>
                        @endif

                        <ul>
                            @for ($i = 1; $i <= $birds->lastPage(); $i++)
                                <li class="{{ $i == $birds->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $birds->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                        </ul>

                        @if ($birds->hasMorePages())
                        <a href="{{ $birds->nextPageUrl() }}" rel="next">&gt;</a>
                        @else
                        <span class="disabled">&gt;</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-footer></x-footer>
</body>

</html>