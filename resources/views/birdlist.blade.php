<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofUH+Tt8+pW1hFQh2lPu5T9zjWgqo9EkP" crossorigin="anonymous"></script>

    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
</head>

<body style="background-image: url('images/b2.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat; color: white;">
    <x-custom-header></x-custom-header>
    <script src="{{ asset('jasonas/jasonas.js') }}"></script>

    <div class="center-container">
        <button id="filterButton" class="btn btn-primary lr-button register custom-button reg">Filter</button>
        <div id="filterContainer">
            <button id="filterTag" class="filterTag FilterDropas" data-bs-toggle="dropdown">Continent</button>
            <div class="dropdown-menu DropDownDesign" id="continentDropdown">
                <a class="dropdown-item DropDownDesign" href="#">Fill1</a>
                <a class="dropdown-item DropDownDesign" href="#">Fill2</a>
                <a class="dropdown-item DropDownDesign" href="#">Fill3</a>
                <a class="dropdown-item DropDownDesign" href="#">Fill4</a>
            </div>
        </div>
    </div>

    <section class="wrapper">
        <div class="container-fostrap">
            <div class="content">
                <div class="container" style="color:black">
                    <!-- Add Bird Button -->
                    @if(auth()->check() && auth()->user()->role == 1)
                    <button type="button" class="btn btn-primary lr-button register custom-button reg" data-bs-toggle="modal" data-bs-target="#addBirdModal">
                        Add Bird
                    </button>
                    @endif
                    <div class="modal fade" style="color:black" id="addBirdModal" tabindex="-1" aria-labelledby="addBirdModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBirdModalLabel">Add New Bird</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.bird.add') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="birdName" class="form-label">Bird Name</label>
                                            <input type="text" class="form-control" name="birdName" id="birdName" placeholder="Enter bird name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="birdImage" class="form-label">Upload Bird Image</label>
                                            <input type="file" class="form-control" name="birdImage" id="birdImage" accept="image/*" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="birdContinent" class="form-label">Bird Continent</label>
                                            <input type="text" class="form-control" name="birdContinent" id="birdContinent" placeholder="Enter bird continent" required>
                                        </div>

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
                </div>
            </div>
        </div>
    </section>
    <!-- Bird Cards -->
    <section class="wrapper">
        <div class="container-fostrap">
            <div class="content">
                <div class="container">
                    <div class="row" style="display: flex; align-items: stretch;">
                        @foreach($birds as $bird)
                        <div class="col-xs-12 col-sm-4" style="margin-bottom: 7%;">
                            <div class="card" style="height: 100%; display: flex; flex-direction: column;">
                                <a class="img-card" href="{{ route('bird.view', ['pavadinimas' => $bird->pavadinimas]) }}">
                                    <img src="{{ asset('images/birds/' . basename($bird->image)) }}" alt="{{ $bird->pavadinimas }}" />
                                </a>
                                <div class="card-content" style="flex: 1;">
                                    <h4 class="card-title">
                                        <a href="#"> {{ $bird->pavadinimas }} </a>
                                    </h4>
                                    <p class=""> {{ $bird->kilme }} </p>
                                    <p class="text-overflow-clamp"> {{ $bird->aprasymas }} </p>
                                </div>
                                <div class="card-read-more">
                                    <!-- Add your buttons for delete, view, and edit here -->
                                    @if(auth()->check() && auth()->user()->role == 1)
                                    <form action="{{ route('admin.bird.delete', ['id' => $bird->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-delete" data-action="delete">Delete</button>
                                    </form>
                                    @endif
                                    <a href="{{ route('bird.view', ['pavadinimas' => $bird->pavadinimas]) }}">View</a>
                                    @if(auth()->check() && auth()->user()->role == 1)
                                    <button href="#" class="btn btn-warning btn-edit" data-action="edit" data-bs-toggle="modal" data-bs-target="#editBirdModal">Edit</button>

                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="pagination">
                <ul>
                    @if ($birds->currentPage() > 1)
                    <li class="prev"><a href="{{ $birds->url(1) }}">«</a></li>
                    @else
                    <li class="disabled prev"><a href="#"></a></li>
                    @endif

                    @php
                    // Display a maximum of 10 pages in the pagination
                    $start = max(1, $birds->currentPage() - 5);
                    $end = min($birds->lastPage(), $start + 9);
                    @endphp

                    @for ($i = $start; $i <= $end; $i++) <li class="{{ $i == $birds->currentPage() ? 'active' : '' }}">
                        <a href="{{ $birds->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor

                        @if ($birds->hasMorePages())
                        <li class="next"><a href="{{ $birds->url($birds->lastPage()) }}">»</a></li>
                        @else
                        <li class="disabled next"><a href="#"></a></li>
                        @endif
                </ul>
            </div>
        </div>
    </div>

    {{-- EDIT BUTTON MODAL --}}

    <div class="modal fade" style="color:black" id="editBirdModal" tabindex="-1" aria-labelledby="editBirdModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBirdModalLabel">Edit information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color:black">
                    <form action="your_php_script.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="birdName" class="form-label">Bird Name</label>
                            <input type="text" class="form-control" name="birdName" id="birdName" placeholder="Enter bird name" required>
                        </div>

                        <div class="mb-3 text-center">
                            <label for="birdName" class="form-label">Current image</label>
                        </div>

                        <div class="mb-3 text-center">
                            <img src="{{ URL('images/birds/bird7.avif')}}" alt="Image" style="float: center; width: 300px; height: 300px;">
                        </div>

                        <div class="mb-3">
                            <label for="birdImage" class="form-label">Change Bird Image</label>
                            <input type="file" class="form-control" name="birdImage" id="birdImage" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="birdContinent" class="form-label">Bird Continent</label>
                            <input type="text" class="form-control" name="birdContinent" id="birdContinent" placeholder="Enter bird continent" required>
                        </div>

                        <div class="mb-3">
                            <label for="birdMiniText" class="form-label">Mini Text</label>
                            <textarea class="form-control" name="birdMiniText" id="birdMiniText" rows="3" placeholder="Enter mini text about the bird" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary custom-edit-button">Edit Bird</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- EDIT BUTTON MODAL END --}}


    <x-footer></x-footer>
</body>

</html>
