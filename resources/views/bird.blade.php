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
        <h1>{{ $bird->pavadinimas }}</h1>
         <div class="image-container">
            <?php
            $imagePath = public_path('images/birds/' . basename($bird->image));
            list($width, $height) = getimagesize($imagePath);
            $imageClass = ($width === $height) ? 'square-image' : 'wide-image';
            ?>
            <img src="{{ asset('images/birds/' . basename($bird->image)) }}" alt="{{ $bird->pavadinimas }}" class="{{ $imageClass }}" />
        </div>
        <p><strong>Country:</strong> {{ $bird->kilme }}</p>
        <h2>About the Bird</h2>
        <p>{!! $bird->aprasymas !!}</p>
    </main>
    <x-footer></x-footer>
</body>
</html>
