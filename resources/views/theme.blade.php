<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Themes</title>
    {{-- <link href="{{ asset('manocss/quizz.css') }}" rel="stylesheet"> --}}
</head>

<style>
    .button {
        padding: 1em 2em;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: #2c9caf;
        transition: all 1000ms;
        font-size: 15px;
        position: relative;
        overflow: hidden;
        outline: 2px solid #2c9caf;
    }

    button:hover {
        color: #ffffff;
        transform: scale(1.1);
        outline: 2px solid #70bdca;
        box-shadow: 4px 5px 17px -4px #268391;
    }

    button::before {
        content: "";
        position: absolute;
        left: -50px;
        top: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg,
                rgba(0, 0, 0, 0.8869922969187675) 20%,
                rgba(3, 177, 177, 1) 100%);
        transform: skewX(45deg);
        z-index: -1;
        transition: width 1000ms;
    }

    button:hover::before {
        width: 250%;
    }
</style>

<body>

  <button class="button">
    Theme
  </button>
  <button class="button">
    Theme
  </button>


</body>

</html>
