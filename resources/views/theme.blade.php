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
        @foreach ($quizzes as $quiz)
            <button class="buttons buttonhome" onclick="window.location.href='/quizz'">{{ $quiz->title}}</button>
        @endforeach
    </div>

    @guest
<div class="box">
    <a href="#m3-o" class="link-1" id="m3-c" style="display: none;"></a>

    <div class="modal-container" id="m3-o" style="--m-background: var(--global-background); display: none;">
        <div class="modal" style="--m-shadow: 0 0 10rem 0">
            <button class="close-button" onclick="closeModal()">X</button>
            <h1 class="modal__title"><strong> HEY THERE</strong></h1>
            <p class="modal__text">Welcome! Log in to save your quiz progress, register for an account to unlock additional features, or continue as a guest to explore and have fun without an account.</p>
            <button class="modal__btn" onclick="window.location.href='/login'">Login &rarr;</button>
            <button class="modal__btn" onclick="window.location.href='/register'">Register &rarr;</button>
            <button class="modal__btn" onclick="closeModal()">Continue as a guest &rarr;</button>
            <a href="#m3-c" class="link-2"></a>
        </div>
    </div>
</div>
@endguest

<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Document is ready.');

        // Check if the modal has been shown in the last 24 hours
        if (!hasModalBeenShownRecently()) {
            console.log('Modal has not been shown recently. Opening modal.');
            openModal();
        } else {
            console.log('Modal has been shown recently. Not opening modal.');
        }
    });

    function openModal() {
        console.log('Opening modal.');
        // Show the overlay and modal container
        document.getElementById('m3-o').style.display = 'flex';
    }

    function closeModal() {
        console.log('Closing modal.');
        // Hide the overlay and modal container
        const modalElement = document.getElementById('m3-o');
        if (modalElement) {
            modalElement.style.display = 'none';

            // Set a cookie to remember that the modal has been shown
            setModalShownCookie();
            console.log('Modal shown cookie set.');
        } else {
            console.error('Modal element not found.');
        }
    }

    function hasModalBeenShownRecently() {
        // Check if the cookie exists and if it has been shown in the last 24 hours
        const lastModalShown = getCookie('lastModalShown');
        if (lastModalShown) {
            const lastShownDate = new Date(lastModalShown);
            const currentDate = new Date();
            const timeDiff = currentDate - lastShownDate;
            const hoursDiff = timeDiff / (1000 * 60 * 60);

            console.log(`Hours since last modal shown: ${hoursDiff}`);
            return hoursDiff < 24;
        }
        return false;
    }

    function setModalShownCookie() {
        // Set a cookie to remember that the modal has been shown
        const currentDate = new Date();
        const expirationDate = new Date(currentDate.getTime() + 24 * 60 * 60 * 1000); // 24 hours
        document.cookie = `lastModalShown=${currentDate.toUTCString()}; expires=${expirationDate.toUTCString()}; path=/`;
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
</script>

</body>

</html>
