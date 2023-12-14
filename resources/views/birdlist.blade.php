<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js">SHA - 256</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">SHA - 384</script>
    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    
    <!-- Add Animate.css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    
</head>

<body loading="lazy"
    style="background: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 100%), linear-gradient(to left, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 100%), url('{{ asset('images/b2.jpg') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; color: white;">

    <x-custom-header></x-custom-header>
    <script src="{{ asset('jasonas/jasonas.js') }}"></script>
    <script src="{{ asset('jasonas/loading.js') }}"></script>

    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    {{-- Sidebar code --}}
    
<div id="wrapper">
   <div class="overlay"></div>
    
        <!-- Sidebar -->
     <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <a href="#">Filter</a>
                </div>
            </div>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Country <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Dropdown Item 1</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Prefix <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Dropdown Item 1</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tag <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Dropdown Item 1</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">TagNull <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Dropdown Item 1</a></li>
                </ul>
            </li>
            <li><a href="#">Clear filters</a></li>
        <li><a href="#">Filter</a></li>
        </ul>
    </nav>

    <div id="page-content-wrapper">
        <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
        </button>
    </div>

</div>
    
    {{-- --}}

    <section class="wrapper">
        <div class="container-fostrap">
            <div class="content">
                <div class="container" style="color:black">
                    <!-- Add Bird Button -->
                    @if (auth()->check() && auth()->user()->role == 1)
                        <button type="button" class="btn btn-primary lr-button register custom-button reg"
                            data-bs-toggle="modal" data-bs-target="#addBirdModal">
                            Add Bird
                        </button>
                    @endif
                    <div class="modal fade" style="color:black" id="addBirdModal" tabindex="-1"
                        aria-labelledby="addBirdModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBirdModalLabel">Add New Bird</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.bird.add') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="birdName" class="form-label">Bird Name</label>
                                            <input type="text" class="form-control" name="birdName" id="birdName"
                                                placeholder="Enter bird name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="birdImages" class="form-label">Upload Bird Images</label>
                                            <input type="file" class="form-control" name="images[]" id="birdImages"
                                                multiple accept="image/*" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="birdContinent" class="form-label">Bird Country</label>
                                            <select class="form-control" name="birdContinent" id="birdContinent"
                                                required>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country }}">{{ $country }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="birdTags" class="form-label">Select Tags</label>
                                            @foreach ($tags as $tag)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="tags[]"
                                                        value="{{ $tag->id }}" id="tag{{ $tag->id }}">
                                                    <label class="form-check-label" for="tag{{ $tag->id }}">
                                                        @if ($tag->prefix)
                                                            {{ $tag->prefix->prefix }}: {{ $tag->name }}
                                                        @else
                                                            {{ $tag->name }}
                                                        @endif
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mb-3" id="editor">
                                            <label for="birdMiniText" class="form-label">Mini Text</label>
                                            <textarea class="form-control" name="birdMiniText" id="birdMiniText" rows="3"
                                                placeholder="Enter mini text about the bird"></textarea>
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
                        @foreach ($bird_card as $bird)
                            <div class="col-xs-12 col-sm-4 bird-card"
                                style="margin-bottom: 7%;">
                                <div class="card" style="height: 100%; display: flex; flex-direction: column;">
                                    <!-- Bootstrap Carousel -->
                                    <div class="img-card">
                                    <div id="carousel{{ $bird->id }}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @php
                                                $images = explode('|', $bird->image);
                                            @endphp
    
                                            @foreach($images as $index => $image)
                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                    <img src="{{ asset($image) }}" loading="lazy" class="d-block w-100" alt="{{ $bird->pavadinimas }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    
                                        @if(count($images) > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $bird->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $bird->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                    <!-- Card Content -->
                                    <div class="card-content" style="flex: 1;">
                                        <h4 class="card-title">
                                            <a href="#"> {{ $bird->pavadinimas }} </a>
                                        </h4>
                                        <p class=""> {{ $bird->kilme }} </p>
                                        @foreach ($bird->tags as $tag)
                                            <span class="badge bg-secondary">
                                                {{ optional($tag->prefix)->prefix ? $tag->prefix->prefix . ':' : '' }}{{ $tag->name }}
                                            </span>
                                        @endforeach
                                        <p class="text-overflow-clamp"> {!! $bird->aprasymas !!} </p>
                                    </div>
                                    <div class="card-read-more">
                                        <!-- Buttons for delete, view, and edit -->
                                        <!-- Add your buttons for delete, view, and edit here -->
                                        @if (auth()->check() && auth()->user()->role == 1)
                                            <form action="{{ route('admin.bird.delete', ['id' => $bird->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-delete"
                                                    data-action="delete">Delete</button>
                                            </form>
                                        @endif
                                        <a
                                            href="{{ route('bird.view', ['pavadinimas' => $bird->pavadinimas]) }}">View</a>
                                        @if (auth()->check() && auth()->user()->role == 1)
                                            <button href="#" class="btn btn-warning btn-edit"
                                                data-action="edit" data-bs-toggle="modal"
                                                data-bs-target="#editBirdModal_{{ $bird->id }}">Edit</button>
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
                    <li class="prev"><a href="">◄</a></li>
                    <li class="next"><a href="">►</a></li>
                </ul>
            </div>
        </div>
    </div>



    {{-- EDIT BUTTON MODAL --}}

    @foreach ($birds as $bird)
        <div class="modal fade" style="color:black" id="editBirdModal_{{ $bird->id }}" tabindex="-1"
            aria-labelledby="editBirdModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBirdModalLabel">Edit information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color:black">
                        <form action="{{ route('admin.editBird', ['birdId' => $bird->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="birdName" class="form-label">Bird Name</label>
                                <input type="text" class="form-control" name="birdName" id="birdName"
                                    placeholder="Enter bird name" value="{{ $bird->pavadinimas }}" required>
                            </div>

                            <div class="mb-3 text-center">
                                <!-- Display current images -->
                                @php
                                    $images = explode('|', $bird->image);
                                @endphp

                                @foreach ($images as $image)
                                    <img src="{{ asset($image) }}" alt="{{ $bird->pavadinimas }}"
                                        style="width: 200px; height: 200px; object-fit: cover; margin: 5px;">
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label for="birdImages" class="form-label">Change Bird Images</label>
                                <input type="file" class="form-control" name="images[]" id="birdImages" multiple
                                    accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label for="birdContinent" class="form-label">Bird Country</label>
                                <select class="form-control" name="birdContinent" id="birdContinent" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}"
                                            {{ $bird->kilme == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="tags" value="">
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                @foreach ($tags as $tag)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="tags[]"
                                            value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                            {{ $bird->tags->contains($tag->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag{{ $tag->id }}">
                                            @if ($tag->prefix)
                                                {{ $tag->prefix->prefix }}: {{ $tag->name }}
                                            @else
                                                {{ $tag->name }}
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label for="birdMiniText" class="form-label">Mini Text</label>
                                <textarea class="form-control" name="birdMiniText" id="birdMiniText" rows="3"
                                    placeholder="Enter mini text about the bird">{{ $bird->aprasymas }}</textarea>
                            </div>
                            <button class="btn btn-warning btn-edit" data-action="edit" data-bs-toggle="modal"
                                data-bs-target="#editBirdModal" data-bird-id="{{ $bird->id }}"
                                data-bird-description="{{ $bird->aprasymas }}">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- EDIT BUTTON MODAL END --}}
    <x-footer></x-footer>
</body>

</html>
