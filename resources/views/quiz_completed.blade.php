<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quiz Completed</title>
</head>

<body>
    <div>
        <h1>Congratulations!</h1>
        <p>You have completed the quiz for {{ $theme->title }}. Well done!</p>
        <form method="post" action="{{ route('resetTheme', ['title' => $theme->title]) }}">
            @csrf
            <button onclick="window.location.href='{{ route('resetTheme', ['title' => $theme->title]) }}'">
                Back to theme
            </button>
        </form>
    </div>
</body>

</html>
