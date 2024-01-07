<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            Theme Management
            <button class="add-button" style="margin-top: -20px;" onclick="openAddModal()"><i
                    class="fas fa-plus"></i>Add Theme</button>
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
        @endforeach
    </div>

    <!-- Modal HTML -->
    <div class="modal-overlay" id="editModalOverlay"></div>
    <div class="modal" id="editThemeModal">
        <h2>Edit Theme</h2>
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
            <h2>Add Theme</h2>
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
        <h2>View Theme Questions</h2>
        <div class="modal-header">
            <button class="close-btn" onclick="closeViewModal()">&times;</button>
            <button class="add-button top-right" onclick="openAddQuestionModal()"><i class="fas fa-plus"></i>Add
                Question</button>
        </div>
        <div id="viewThemeNameContainer">
            <strong>Theme Name:</strong>
            <p id="viewThemeName"></p>
        </div>
        <div style="width: 100%;">
            <div id="questionsContainer">
                <!-- Questions will be appended here -->
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editQuestionModalOverlay"></div>
    <div class="modal" id="editQuestionModal">
        <h2>Edit Question</h2>
        <input type="text" id="editQuestionName" placeholder="Enter new question name">
        <div class="button-row">
            <button class="edit-button" onclick="editQuestion()">Edit</button>
            <button class="cancel" onclick="closeEditModal()">Cancel</button>
        </div>
    </div>

    <div class="modal-overlay" id="addQuestionModalOverlay"></div>
    <div class="modal" id="addQuestionModal">
        <h2>Add Question</h2>
        <input type="text" id="addQuestionName" placeholder="Enter question name">
        <div class="button-row">
            <button class="add-button" onclick="addQuestion()">Add</button>
            <button class="cancel" onclick="closeAddQuestionModal()">Cancel</button>
        </div>
    </div>


    <!-- New Question Modal -->
    <div class="modal-overlay" id="questionModalOverlay"></div>
    <div class="modal" id="questionModal">
        <h2>View Question</h2>
        <button class="close-btn" onclick="closeQuestionModal()">&times;</button>
        <button class="add-button top-right" onclick="openAddAnswerModal()"><i class="fas fa-plus"></i>Add
            Answer</button>
        <div id="viewThemeNameContainer">
            <strong>Question Name:</strong>
            <p id="questionContainer"></p>
        </div>

        <div style="width: 100%;">
            <div class="theme-item">
                <div>
                    <strong>Question 1</strong>
                </div>
                <div class="theme-item-actions">
                    <button class="edit-button" onclick="openEditAnswerModal()" data-toggle="tooltip"
                        data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="delete-button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                            class="fas fa-times"></i></button>
                </div>
                <!-- Add x and checkmark buttons here -->
                <div class="extra-buttons">
                    <button class="extra-button x-button" onclick="toggleButton('x', 1)" title="Value:"><i
                            class="fas fa-times"></i></button>
                    <button class="extra-button check-button" onclick="toggleButton('check', 1)" title="Value:"><i
                            class="fas fa-check"></i></button>
                </div>
            </div>
            </div>
        </div>

        <div class="modal-overlay" id="addAnswerModalOverlay"></div>
        <div class="modal" id="addAnswerModal">
            <h2>Add Answer</h2>
            <input type="text" id="answerText" placeholder="Enter your answer">
            <div class="button-row">
                <button class="add-button" onclick="addAnswer()">Add</button>
                <button class="cancel" onclick="closeAddAnswerModal()">Cancel</button>
            </div>
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

</body>

</html>
