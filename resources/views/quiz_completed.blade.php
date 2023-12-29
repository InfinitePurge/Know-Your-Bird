<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quiz Completed</title>
    <link href="{{ asset('manocss/quiz_completed.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Congratulations!</h1>
        <p>You have completed the quiz for <strong>{{ $theme->title }}</strong>. Well done!</p>

        <h2>Your Score: {{ $score }}%</h2>
        <p>Time Spent: {{ intdiv($timeSpend, 60) }} minutes and {{ $timeSpend % 60 }} seconds</p>

        <h2>Your Answers:</h2>
        @foreach ($userAnswers as $key => $userAnswer)
            <div class="question">
                <p class="question-counter">Question {{ $key + 1 }}: {{ $userAnswer->question->question }}</p>
                @if ($userAnswer->answer)
                    <p class="answer"><strong>Your Answer:</strong> {{ $userAnswer->answer->AnswerText }}</p>
                    <p class="{{ $userAnswer->answer->isCorrect ? 'correct' : 'incorrect' }}">
                        <strong>Correct:</strong> {{ $userAnswer->answer->isCorrect ? 'Yes' : 'No' }}
                    </p>
                @else
                    <p class="answer"><strong>Your Answer:</strong> Answer not found</p>
                    <p class="incorrect"><strong>Correct:</strong> No</p>
                @endif
            </div>
        @endforeach

        <button onclick="window.location.href='{{ route('theme') }}'">
            Back to Theme Selection
        </button>
    </div>
</body>

</html>
