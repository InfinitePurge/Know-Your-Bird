<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>{{ $theme->title }} Quiz</title>
    <link href="{{ asset('manocss/quizz.css') }}" rel="stylesheet">
</head>

<body>
    <a href="{{ route('theme') }}" class="home-button"><i class="fas fa-arrow-left"></i></a>

    <div class="container">
        @if (isset($question))
            <div class="header">{{ $question->question }}</div>
            <div class="image-container">
                <img src="{{ $question->image_url }}" alt="Error on loading image" style="max-width:100%;height:auto;">
            </div>
            <div class="buttons">
                @foreach ($question->answers->shuffle() as $answer)
                    <form method="post" action="{{ route('answer', ['title' => $theme->title]) }}">
                        @csrf
                        <input type="hidden" name="chosen_answer_id" value="{{ $answer->encrypted_id }}">
                        <button type="submit" class="quiz-button green">
                            {{ $answer->AnswerText }} {{ $answer->isCorrect }}
                        </button>
                    </form>
                @endforeach
            </div>
        @else
            <p>No questions available for this quiz.</p>
        @endif
    </div>
</body>

</html>
