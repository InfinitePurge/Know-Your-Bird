<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel Quiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/modal.js/0.11.0/modal.min.css">
    <script src="https://unpkg.com/tippy.js@6.3.3/dist/tippy-bundle.umd.js"></script>
    <link href="{{ asset('manocss/addquiz.css') }}" rel="stylesheet">
    <script src="{{ asset('jasonas/addquiz.js') }}"></script>

</head>

<body>

    <x-adminsidebar></x-adminsidebar>

    <div class="crud-container">
        <h2>
            Topic Management
            <button class="add-button" style="margin-top: -20px;" onclick="openAddModal()"><i
                    class="fas fa-plus"></i>Add Topic</button>
        </h2>

        @if (session('success'))
            <div class="alert alert-success">
                <h4 style="-webkit-text-fill-color: rgb(43, 255, 0)">{{ session('success') }}</h4>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <h4 style="-webkit-text-fill-color: red">{{ session('error') }}</h4>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @foreach ($quizThemes as $quizTheme)
            <div class="theme-item">
                <div>
                    <strong>ID: {{ $quizTheme->id }} - {{ $quizTheme->title }}</strong>
                </div>
                <div class="theme-item-actions">
                    <button class="view-button"
                        onclick="openViewModal('{{ $quizTheme->id }}', '{{ $quizTheme->title }}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="edit-button"
                        onclick="editModalOverlay('{{ $quizTheme->encrypted_id }}', '{{ $quizTheme->title }}')">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <form action="{{ route('admin.quiz.delete', $quizTheme->encrypted_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button"><i class="fas fa-times"></i></button>
                    </form>
                </div>
            </div>

            <!-- Modal HTML -->
            <div class="modal-overlay" id="editModalOverlay"></div>
            <div class="modal" id="editThemeModal">
                <h2>Edit Topic</h2>
                <form id="editThemeForm" action="{{ route('admin.quiz.editThemeTitle') }}" method="POST">
                    @csrf
                    <input type="hidden" id="editThemeId" name="id">
                    <input type="text" id="newThemeName" name="title" placeholder="Enter new theme name">
                    <div class="button-row">
                        <button type="submit" class="edit-button">Edit</button>
                        <button class="cancel" onclick="closeEditThemeModal(); return false;">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Add Theme Modal -->
            <div class="modal-overlay" id="addModalOverlay"></div>
            <div class="modal" id="addModal">
                <form action="{{ route('admin.quiz.addTheme') }}" method="POST">
                    @csrf
                    <h2>Add Topic</h2>
                    <input type="text" id="addThemeName" name="title" placeholder="Enter theme name">
                    <div class="button-row">
                        <button type="submit" class="add-button">Add</button>
                        <button class="cancel" onclick="closeAddModal(); return false;">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- View Theme Modal -->
            <div class="modal-overlay" id="viewModalOverlay"></div>
            <div class="modal" id="viewModal">
                <h2>View Topic Questions</h2>
                <div class="modal-header">
                    <button class="close-btn" onclick="closeViewModal()">&times;</button>
                    <button class="add-button top-right" onclick="openAddQuestionModal()"><i class="fas fa-plus"></i>Add
                        Question</button>
                </div>
                <div id="viewThemeNameContainer">
                    <strong>Topic Name:</strong>
                    <p id="viewThemeName"></p>
                </div>
                <div style="width: 100%;">
                    <div id="successMessage" class="alert alert-success" style="display:none; color: rgb(43, 255, 0);">
                    </div>
                    <div id="questionsContainer">
                        <!-- Questions will be appended here -->
                    </div>
                </div>
            </div>

            <div class="modal-overlay" id="editQuestionModalOverlay"></div>
            <div class="modal" id="editQuestionModal">
                <h2>Edit Question</h2>
                <input type="hidden" id="editQuestionId" value="">
                <input type="text" id="editQuestionName" placeholder="Enter new question name">
                <div class="button-row">
                    <button class="edit-button" onclick="editQuestion()">Edit</button>
                    <button class="cancel" onclick="closeEditModal()">Cancel</button>
                </div>
            </div>

            <div class="modal-overlay" id="addQuestionModalOverlay"></div>
            <div class="modal" id="addQuestionModal">
                <form action="{{ route('admin.quiz.addQuestion') }}" method="POST">
                    @csrf
                    <h2>Add Question</h2>
                    <input type="text" id="addQuestionName" name="question" placeholder="Enter question name">
                    <input type="hidden" name="quiz_id" value="{{ $quizTheme->encrypted_id }}">
                    <div class="button-row">
                        <button type="submit" class="add-button">Add</button>
                        <button type="button" class="cancel" onclick="closeAddQuestionModal()">Cancel</button>
                    </div>
                </form>
            </div>


            <!-- New Question Modal -->
            @foreach ($quizTheme->questions as $question)
                <div class="modal-overlay" id="questionModalOverlay"></div>
                <div class="modal" id="questionModal">
                    <h2>View Question</h2>
                    <button class="close-btn" onclick="closeQuestionModal()">&times;</button>
                    <!-- Your button here -->
                    <?php $encryptedId = Crypt::encryptString($question->id); ?>
                    <button class="add-button top-right" onclick="openAddAnswerModal('{{ $encryptedId }}')">Add
                        Answer</button>
                    <div id="viewThemeNameContainer">
                        <strong>Question Name:</strong>
                        <p id="questionContainer"></p>
                    </div>

                    <div style="width: 100%;">
                        <div id="answersContainer">
                            <!-- Answers will be appended here -->
                        </div>
                    </div>
                </div>

                <div class="modal-overlay" id="addAnswerModalOverlay"></div>
                <div class="modal" id="addAnswerModal">
                    <h2>Add Answer</h2>
                    <form action="{{ route('admin.quiz.addAnswer') }}" method="POST">
                        @csrf
                        <input type="hidden" name="question_id" id="questionIdField" value="" />
                        <input type="text" id="answerText" name="answer" placeholder="Enter your answer">
                        <label for="isCorrect">Is Correct:</label>
                        <label for="isCorrect">Is Correct:</label>
                        <select id="isCorrect" name="isCorrect">
                            <option value="true">Yes</option>
                            <option value="false">No</option>
                        </select>
                        <div class="button-row">
                            <button type="submit" class="add-button">Add</button>
                            <button type="button" class="cancel" onclick="closeAddAnswerModal()">Cancel</button>
                        </div>
                    </form>
                </div>

                <div class="modal-overlay" id="editAnswerModalOverlay"></div>
                <div class="modal" id="editAnswerModal">
                    <h2>Edit Answer</h2>
                    <input type="text" id="editAnswerText" placeholder="Enter new answer">
                    <div class="button-row">
                        <button class="add-button" onclick="editAnswer()">Edit</button>
                        <button class="cancel" onclick="closeEditAnswerModal()">Cancel</button>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>

</body>

</html>
