<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quiz Completed</title>
</head>

<body>
    <div>
        <h1>Congratulations!</h1>
        <p>You have completed the quiz for {{ $theme->title }}. Well done!</p>

        <h2>Your Answers:</h2>
        @foreach ($userAnswers as $userAnswer)
            <p>Question: {{ $userAnswer->question->question }}</p>
            <p>Your Answer: {{ $userAnswer->answer->AnswerText }}</p>
            <p>Correct: {{ $userAnswer->answer->isCorrect ? 'Yes' : 'No' }}</p>
        @endforeach

        <button onclick="window.location.href='{{ route('theme') }}'">
            Back to theme
        </button>
    </div>
</body>

</html>
