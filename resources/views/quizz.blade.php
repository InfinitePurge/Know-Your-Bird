<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>{{ $theme->title }} Quiz</title>
    <link href="{{ asset('manocss/quizz.css') }}" rel="stylesheet">
</head>

<body>
    <script src="{{ asset('jasonas/quiz_blade.js') }}"></script>
    <a href="{{ route('theme') }}" class="home-button"><i class="fas fa-arrow-left"></i></a>

    <div class="container">
        @if (isset($question))
            <div class="header">{{ $question->question }}</div>
            <div class="image-container">
                <img src="{{ $question->image_url }}" style="max-width:100%;height:auto;">
            </div>
            <div class="buttons">
                @foreach ($question->answers as $answer)
                    <button type="button" class="quiz-button green" data-answer-id="{{ $answer->encrypted_id }}">
                        {{ $answer->AnswerText }}{{ $answer->isCorrect ? ' (correct)' : '' }}
                    </button>
                @endforeach
            </div>
        @else
            <p>No questions available for this quiz.</p>
        @endif
    </div>
    <script type="text/javascript">
        var quizRoutes = {
            answer: "{{ route('answer', ['title' => $theme->title, 'questionID' => $question->id]) }}",
            quizCompleted: "{{ route('quiz_completed', ['title' => $theme->title]) }}"
        };
        var csrfToken = "{{ csrf_token() }}";
    </script>
</body>

</html>
