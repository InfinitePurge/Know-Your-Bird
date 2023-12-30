$(document).ready(function () {
    $(".buttons").on("click", ".quiz-button", function () {
        var answerId = $(this).data("answer-id");
        submitAnswer(answerId);
    });

    function submitAnswer(answerId) {
        $.ajax({
            url: quizRoutes.answer,
            type: "POST",
            data: {
                _token: csrfToken,
                chosen_answer_id: answerId,
            },
            success: function (response) {
                if (response.status === "continue") {
                    updateQuestion(response.nextQuestion);
                } else if (response.status === "completed") {
                    window.location.href = quizRoutes.quizCompleted;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                alert("Error submitting answer. Please try again.");
            },
        });
    }

    function updateQuestion(question) {
        $(".buttons").empty();

        $.each(question.answers, function (index, answer) {
            var buttonText =
                answer.AnswerText + (answer.isCorrect ? " (correct)" : "");

            var button = $("<button/>", {
                type: "button",
                html: buttonText,
                class: "quiz-button green",
                "data-answer-id": answer.encrypted_id,
            });

            $(".buttons").append(button);
        });

        $(".header").text(question.question);
    }
});
