<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('manocss/bird.css') }}" rel="stylesheet">
    <title>Bird - {{ $bird->pavadinimas }}</title>
</head>
<x-custom-header></x-custom-header>

<body>
    <main>
        <h1><strong>Bird:</strong>{{ $bird->pavadinimas }}</h1>
        <div class="image-container">
            @php
                $images = explode('|', $bird->image);
            @endphp
        
            @foreach($images as $image)
                <?php
                $imagePath = public_path($image);
                [$width, $height] = getimagesize($imagePath);
                $imageClass = $width === $height ? 'square-image' : 'wide-image';
                ?>
                <img src="{{ asset($image) }}" alt="{{ $bird->pavadinimas }}" class="{{ $imageClass }}" />
            @endforeach
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
</body>

</html>
