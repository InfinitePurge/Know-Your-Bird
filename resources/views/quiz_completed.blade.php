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
                <p class="answer"><strong>Your Answer:</strong> {{ $userAnswer->answer->AnswerText }}</p>
                <p class="{{ $userAnswer->isCorrect ? 'correct' : 'incorrect' }}">
                    <strong>Correct:</strong> {{ $userAnswer->isCorrect ? 'Yes' : 'No' }}
                </p>
                <!-- Removed correctness display since it's not relevant anymore -->
            </div>
        @endforeach

        <button onclick="window.location.href='{{ route('theme') }}'">
            Back to Theme Selection
        </button>
    </div>
</body>

</html>