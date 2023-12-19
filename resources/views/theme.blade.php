<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Themes</title>
    <link href="{{ asset('manocss/theme.css') }}" rel="stylesheet">
</head>

<body>
    <button class="home-button buttonhome" onclick="window.location.href='/'">&#8962; Home</button>

    <div class="button-container">
        <button class="buttons buttonhome" onclick="window.location.href='/quizz'">Theme 1</button>
        <button class="buttons buttonhome">Theme 2</button>
        <button class="buttons buttonhome">Theme 3</button>
        <button class="buttons buttonhome">Theme 4</button>
        <button class="buttons buttonhome">Theme 5</button>
        <button class="buttons buttonhome">Theme 6</button>
        <button class="buttons buttonhome">Theme 7</button>
    </div>

    
       <div class="box">
        <a href="#m3-o" class="link-1" id="m3-c" style="display: none;"></a>

        <div class="modal-container" id="m3-o" style="--m-background: var(--global-background);">
            <div class="modal" style="--m-shadow: 0 0 10rem 0">
                <button class="close-button" onclick="closeModal()">X</button>
                <h1 class="modal__title"><strong> HEY THERE</strong></h1>
                <p class="modal__text">Welcome! Log in to save your quiz progress, register for an account to unlock additional features, or continue as a guest to explore and have fun without an account.</p>
                <button class="modal__btn">Login &rarr;</button>
                <button class="modal__btn">Register &rarr;</button>
                <button class="modal__btn">Continue as a guest &rarr;</button>
                <a href="#m3-c" class="link-2"></a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if the modal has been shown today
            if (!hasModalBeenShownToday()) {
                openModal();
            }
        });

        function openModal() {
            // Show the overlay and modal container
            document.getElementById('m3-o').style.display = 'flex';
        }

        function closeModal() {
            // Hide the overlay and modal container
            document.getElementById('m3-o').style.display = 'none';

            // Set a cookie to remember that the modal has been shown today
            setModalShownCookie();
        }
    </script>
</body>

</html>
