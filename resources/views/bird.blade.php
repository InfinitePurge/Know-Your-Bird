<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link href="{{ asset('manocss/bird.css') }}" rel="stylesheet">
    <title>Bird - {{ $bird->pavadinimas }}</title>

    <style>
        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .big-photo {
            width: 100%;
            height: 30em;
            object-fit: cover;
            overflow: hidden;
            display: block;
            margin-bottom: 10px;
        }

        .small-photo {
            width: 5em;
            height: 8em;
            object-fit: cover;
            margin-right: 10px;
            cursor: pointer;
        }

        .small-photos-container {
            display: flex;
            justify-content: center;
        }
    </style>

</head>
<x-custom-header></x-custom-header>

<body>
    <main>
        <h1><strong>Bird:</strong>{{ $bird->pavadinimas }}</h1>
        <div class="image-container">
            @php
                $images = explode('|', $bird->image);
            @endphp
            <img src="{{ asset($images[0]) }}" alt="{{ $bird->pavadinimas }}" class="big-photo" id="bigPhoto" />
            <div class="small-photos-container">
                @foreach ($images as $index => $image)
                    @if ($index > 0)
                        <img src="{{ asset($image) }}" alt="{{ $bird->pavadinimas }}" class="small-photo"
                            data-index="{{ $index }}" />
                    @endif
                @endforeach
            </div>
        </div>
        <p><strong>Country:</strong> {{ $bird->kilme }}</p>
        @foreach ($sortedTags as $tag)
            <span class="badge bg-secondary">
                {{ optional($tag->prefix)->prefix ? $tag->prefix->prefix . ':' : '' }}{{ $tag->name }}
                <br>
            </span>
        @endforeach
        <h2>About the Bird</h2>
        <p>{!! $bird->aprasymas !!}</p>
    </main>
    <x-footer></x-footer>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var images = @json($images);
        var currentImageIndex = 0;

        $(".small-photo").click(function () {
            var index = $(this).data("index");
            var bigPhoto = $("#bigPhoto");
            var smallPhoto = $(this);

            // Check if the clicked photo is different from the current big photo
            if (index !== currentImageIndex) {
                // Stop the current animation (if any) and clear the queue
                bigPhoto.stop(true, true);

                // Fade out the big photo
                bigPhoto.fadeOut("fast", function () {
                    // Swap the src attributes of big and small photos
                    var tempSrc = bigPhoto.attr("src");
                    bigPhoto.attr("src", smallPhoto.attr("src"));
                    smallPhoto.attr("src", tempSrc);

                    // Fade in the big photo
                    bigPhoto.fadeIn("fast");
                });

                currentImageIndex = index;
            }
        });
    });
</script>

</body>

</html>
