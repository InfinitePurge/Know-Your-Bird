<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js">
        SHA - 256
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
        SHA - 384
    </script>
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
    <script src="{{ asset('jasonas/add_edit_birdlist.js') }}"></script>

    <div id="wrapper">
        <div class="overlay"></div>

        <!-- Sidebar -->
        <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
            <form method="GET" action="{{ route('birdlist.filter') }}" id="filterForm">
                <ul class="nav sidebar-nav">
                    <div class="sidebar-header">
                        <div class="sidebar-brand">
                            <a>Filter</a>
                        </div>
                    </div>
                    <!-- Country Filter -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Country</a>
                        <ul class="dropdown-menu">
                            @foreach ($countriesWithBirds as $countryWithBird)
                                <li>
                                    <a href="#"
                                        onclick="toggleFilterValue('countries', '{{ $countryWithBird }}', this);">
                                        {{ $countryWithBird }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <input type="hidden" id="countries" name="countries" value="{{ request('countries', '') }}">

                    <!-- Prefix Filter -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Prefix</a>
                        <ul class="dropdown-menu">
                            @foreach ($usedPrefixes as $prefix)
                                <li>
                                    <a href="#"
                                        onclick="toggleFilterValue('prefixes', '{{ $prefix->prefix }}', this);">{{ $prefix->prefix }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <input type="hidden" id="prefixes" name="prefixes" value="{{ request('prefixes', '') }}">

                    <!-- Tag Filter -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tag</a>
                        <ul class="dropdown-menu">
                            @foreach ($usedTagsWithPrefix as $tag)
                                <li>
                                    <a href="#"
                                        onclick="toggleFilterValue('tags', '{{ $tag->name }}', this);">{{ $tag->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <input type="hidden" id="tags" name="tags" value="{{ request('tags', '') }}">

                    <!-- TagNull Filter -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">TagNull</a>
                        <ul class="dropdown-menu">
                            @foreach ($usedTagsWithNullPrefix as $tagNull)
                                <li>
                                    <a href="#"
                                        onclick="toggleFilterValue('tagNulls', '{{ $tagNull->name }}', this);">{{ $tagNull->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <input type="hidden" id="tagNulls" name="tagNulls" value="{{ request('tagNulls', '') }}">

                    <li><a href="#" onclick="document.getElementById('filterForm').submit();">Apply Filter</a>
                    </li>
                    <li><a href="{{ route('birdlist.filter') }}">Clear Filter</a></li>
                    <div id="filter-tags" class="filter-tags"> </div>
                </ul>
            </form>
        </nav>

        <div id="page-content-wrapper">
            <div id="page-content-wrapper">
                <button type="button" class="filter-button animated fadeInLeft is-closed" data-toggle="offcanvas">
                    Filters
                </button>
            </div>
        </div>

        <!-- Filter Tags Display -->


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
                                            <input type="text" class="form-control" name="birdName"
                                                id="birdName" placeholder="Enter bird name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="birdImages" class="form-label">Upload Bird Images</label>
                                            <!-- The file input retains its original 'form-control' class for styling -->
                                            <input type="file" class="form-control" name="images[]"
                                                id="birdImages" multiple accept="image/*"
                                                onchange="handleFiles(this.files)">
                                            <!-- Div to display file names and replace/remove buttons -->
                                            <div id="file-list" class="file-list"></div>
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
                                        <label for="birdTags" class="form-label">Select Tags</label>
                                        <div class="mb-3">
                                            <div
                                                style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; padding: 5px;">
                                                @foreach ($tags as $tag)
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="tags[]" value="{{ $tag->id }}"
                                                            id="tag{{ $tag->id }}" onmousedown="blurInputs()">
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
                                        </div>

                                        <div class="mb-3" id="editor">
                                            <label for="birdMiniText" class="form-label">Mini Text</label>
                                            <textarea class="form-control" name="birdMiniText" id="birdMiniText" rows="3"
                                                placeholder="Enter mini text about the bird"></textarea>
                                        </div>
                                        <button type="submit" onclick="submitForm()" class="btn btn-primary">Add
                                            Bird</button>
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
                            <div class="col-xs-12 col-sm-4 bird-card" style="margin-bottom: 7%;">
                                <div class="card" style="height: 100%; display: flex; flex-direction: column;">
                                    <!-- Bootstrap Carousel -->
                                    <div class="img-card">
                                        <div id="carousel{{ $bird->id }}" class="carousel slide"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @php
                                                    $images = explode('|', $bird->image);
                                                @endphp

                                                @foreach ($images as $index => $image)
                                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                        <img src="{{ asset($image) }}" loading="lazy"
                                                            class="d-block w-100" alt="{{ $bird->pavadinimas }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if (count($images) > 1)
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#carousel{{ $bird->id }}"
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"
                                                        aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#carousel{{ $bird->id }}"
                                                    data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"
                                                        aria-hidden="true"></span>
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
                                    @if (auth()->check() && auth()->user()->role == 1)
                                        <form action="{{ route('admin.bird.delete', ['id' => $bird->id]) }}"
                                            method="POST" style="position: absolute; top: 0; right: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-delete"
                                                data-action="delete">&#10006;</button>
                                        </form>
                                    @endif
                                    @if (auth()->check() && auth()->user()->role == 1)
                                        <button class="btn btn-warning btn-edit" data-action="edit"
                                            style="position: absolute; top: 0; left: 0;" data-bs-toggle="modal"
                                            data-bs-target="#editBirdModal_{{ $bird->id }}">&#9998;</button>
                                    @endif
                                    <div class="card-read-more">
                                        <a
                                            href="{{ route('bird.view', ['pavadinimas' => $bird->pavadinimas]) }}">View</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($bird_card->hasPages())
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="pagination">
                    <ul>
                        @php
                            $queryParameters = request()->query();
                            unset($queryParameters['page']);
                            $queryParameters = http_build_query($queryParameters);
                            $totalPages = $bird_card->lastPage();
                            $currentPage = $bird_card->currentPage();
                            $visiblePages = 8; // Number of pages to display
                            $halfVisible = floor($visiblePages / 2);
                            $startPage = max(1, $currentPage - $halfVisible);
                            $endPage = min($totalPages, $startPage + $visiblePages - 1);
                        @endphp

                        {{-- Previous Page Link --}}
                        @if ($bird_card->onFirstPage())
                            <li class="prev disabled"><a href="javascript:void(0)">◄</a></li>
                        @else
                            <li class="prev"><a
                                    href="{{ $bird_card->previousPageUrl() . (parse_url($bird_card->previousPageUrl(), PHP_URL_QUERY) ? '&' : '?') . $queryParameters }}">◄</a>
                            </li>
                        @endif

                        {{-- First Page Link --}}
                        @if ($startPage > 1)
                            <li><a
                                    href="{{ $bird_card->url(1) . (parse_url($bird_card->url(1), PHP_URL_QUERY) ? '&' : '?') . $queryParameters }}">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li><a>...</a></li>
                            @endif
                        @endif

                        {{-- Page Numbers --}}
                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li @if ($i == $currentPage) class="active" @endif><a
                                    href="{{ $bird_card->url($i) . (parse_url($bird_card->url($i), PHP_URL_QUERY) ? '&' : '?') . $queryParameters }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Last Page Link --}}
                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <li><a>...</a></li>
                            @endif
                            <li><a
                                    href="{{ $bird_card->url($totalPages) . (parse_url($bird_card->url($totalPages), PHP_URL_QUERY) ? '&' : '?') . $queryParameters }}">{{ $totalPages }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($bird_card->hasMorePages())
                            <li class="next"><a
                                    href="{{ $bird_card->nextPageUrl() . (parse_url($bird_card->nextPageUrl(), PHP_URL_QUERY) ? '&' : '?') . $queryParameters }}">►</a>
                            </li>
                        @else
                            <li class="next disabled"><a href="javascript:void(0)">►</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endif





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
                            <label class="form-label">Tags</label>
                            <div class="mb-3" style="max-height: 150px; overflow-y: auto;">
                                
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
    <script>
        window.onload = function() {
            createFilterTags('countries');
            createFilterTags('prefixes');
            createFilterTags('tags');
            createFilterTags('tagNulls');
        };

        function createFilterTags(filterName) {
            var input = document.getElementById(filterName);
            var values = input.value ? input.value.split(',') : [];

            // Check if values are present before creating the filter tag div
            if (values.length > 0) {
                var filterTagId = filterName + '-filter-tag';
                var filterTagsContainer = document.getElementById('filter-tags');
                var filterTag = document.createElement('div');
                filterTag.id = filterTagId;
                filterTag.className = 'filter-tag';

                for (var i = 0; i < values.length; i++) {
                    filterTag.innerHTML += '<a>' + values[i] + '</a><span class="close-btn" onclick="removeFilterTag(\'' +
                        filterTagId + '\', \'' + values[i] + '\')">x</span>';
                }

                filterTagsContainer.appendChild(filterTag);
            }
        }

        function toggleFilterValue(filterName, value, element) {
            var input = document.getElementById(filterName);
            var currentValues = input.value ? input.value.split(',') : [];

            // Check if the value is already selected
            var valueIndex = currentValues.indexOf(value);

            if (valueIndex === -1) {
                currentValues.push(value); // Add the value if not present
            } else {
                currentValues.splice(valueIndex, 1); // Remove the value if already present
            }

            input.value = currentValues.join(','); // Update the hidden input value
            element.classList.toggle('selected'); // Optional: for visual feedback

            // Update the filter tag
            updateFilterTag(filterName, value, currentValues);
        }

        function updateFilterTag(filterName, value, currentValues) {
            var filterTagId = filterName + '-filter-tag';
            var filterTagName = value;
            var filterTag = document.getElementById(filterTagId);

            if (!filterTag) {
                // Create filter tag element if not present
                filterTag = document.createElement('div');
                filterTag.id = filterTagId;
                filterTag.className = 'filter-tag';
                document.getElementById('filter-tags').appendChild(filterTag);
            }

            // Check if values are present before updating the filter tag div
            if (currentValues.length > 0) {
                filterTag.innerHTML = '';

                for (var i = 0; i < currentValues.length; i++) {
                    filterTag.innerHTML += '<a>' + currentValues[i] +
                        '</a><span class="close-btn" onclick="removeFilterTag(\'' +
                        filterTagId + '\', \'' + currentValues[i] + '\')">x</span>';
                }
            } else {
                // Remove the filter tag div if no values are present
                filterTag.parentNode.removeChild(filterTag);
            }
        }

        function removeFilterTag(filterTagId, value) {
            // Remove the value from the hidden input
            var input = document.getElementById(filterTagId.replace('-filter-tag', ''));
            var currentValues = input.value ? input.value.split(',') : [];
            var valueIndex = currentValues.indexOf(value);

            if (valueIndex !== -1) {
                currentValues.splice(valueIndex, 1);
                input.value = currentValues.join(','); // Update the hidden input value
            }

            // Update the filter tag
            updateFilterTag(filterTagId.replace('-filter-tag', ''), value, currentValues);
        }
    </script>

</body>

</html>
