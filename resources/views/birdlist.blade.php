<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js">
        SHA - 256
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
        SHA - 384
    </script>

    <link href="{{ asset('manocss/mycss.css') }}" rel="stylesheet">



</head>

<body
    style="background: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 100%), linear-gradient(to left, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 100%), url('{{ asset('images/b2.jpg') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; color: white;">

    <x-custom-header></x-custom-header>
    <script src="{{ asset('jasonas/jasonas.js') }}"></script>
    <script src="{{ asset('jasonas/loading.js') }}"></script>

    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    {{-- Country button --}}
    <div class="container-fluid filtercontainer">
        <p style="text-align: center;"> Filter by: </p>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6 d-flex justify-content-between">
                <div class="btn-group" id="kilmeButtonGroup">
                    <button type="button" class="btn btn-secondary filtromygt" id="kilmeButton">Country</button>
                    <div class="dropdown-menu scrollable-menu DropDownDesignForNav" id="salisDropdown">
                        @foreach ($kilmeValues as $kilme)
                            <a class="dropdown-item bird DropDownText" href="#">{{ $kilme }}</a>
                        @endforeach
                    </div>
                </div>
                {{--  --}}
                {{-- Prefix button --}}
                <div class="btn-group" id="">
                    <button type="button" class="btn btn-secondary filtromygt" id="prefixButton">Prefix</button>
                    <div class="dropdown-menu scrollable-menu DropDownDesignForNav" id="prefixDropdown">
                        @foreach ($prefixes as $prefixItem)
                            <a class="dropdown-item bird DropDownTextPrefix" data-prefix="{{ $prefixItem->id }}"
                                href="#">{{ $prefixItem->prefix }}</a>
                        @endforeach
                    </div>
                </div>
                {{--  --}}
                {{-- Tag button --}}
                <div class="btn-group" id="">
                    <button type="button" class="btn btn-secondary filtromygt" id="TagButton">Tag</button>
                    <div class="dropdown-menu scrollable-menu DropDownDesignForNav" id="TagDropdown">
                        @foreach ($tagies as $tagItem)
                            <a class="dropdown-item bird DropDownTextTag" data-tag="{{ $tagItem->id }}"
                                href="#">{{ $tagItem->name }}</a>
                        @endforeach
                    </div>
                </div>
                {{--  --}}
                {{-- Null Tag button --}}
                <div class="btn-group" id="">
                    <button type="button" class="btn btn-secondary filtromygt" id="TagNullButton">Tagnull</button>
                    <div class="dropdown-menu scrollable-menu DropDownDesignForNav" id="TagNullDropdown">
                        @foreach ($tagiesNull as $tagnullItem)
                            <a class="dropdown-item bird DropDownTextTagNull" data-tagnull="{{ $tagnullItem->id }}"
                                href="#">{{ $tagnullItem->name }}</a>
                        @endforeach
                    </div>
                </div>
                {{--  --}}

                <button type="button" class="btn btn-outline-secondary filtromygt" id="clearFilter">Clear
                    Filter</button>
            </div>
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
                                            <label for="birdImage" class="form-label">Upload Bird Image</label>
                                            <input type="file" class="form-control" name="birdImage" id="birdImage"
                                                accept="image/*" required>
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
                            <div class="col-xs-12 col-sm-4 bird-card" data-tagnull="{{ $tagnullItem}}" data-tag="{{ $bird->tags->pluck('id') }}"
                                data-prefix="{{ $bird->prefix_id }}" data-continent="{{ $bird->kilme }}"
                                style="margin-bottom: 7%;">
                                <div class="card" style="height: 100%; display: flex; flex-direction: column;">
                                    <a class="img-card"
                                        href="{{ route('bird.view', ['pavadinimas' => $bird->pavadinimas]) }}">
                                        <img src="{{ asset('images/birds/' . basename($bird->image)) }}"
                                            alt="{{ $bird->pavadinimas }}" />
                                    </a>
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
                                <label for="birdName" class="form-label">Current image</label>
                            </div>

                            <div class="mb-3 text-center"">
                                <img src="{{ asset('images/birds/' . basename($bird->image)) }}"
                                    alt="{{ $bird->pavadinimas }}"
                                    style="width: 400px; height: 400px; object-fit: cover;">
                            </div>

                            <div class="mb-3">
                                <label for="birdImage" class="form-label">Change Bird Image</label>
                                <input type="file" class="form-control" name="birdImage" id="birdImage"
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
