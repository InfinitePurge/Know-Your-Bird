<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Quiz</title>
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Include Modal.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/modal.js/0.11.0/modal.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modal.js/0.11.0/modal.min.js"></script>
    <link href="{{ asset('manocss/addquiz.css') }}" rel="stylesheet">
    <script src="{{ asset('jasonas/addquiz.js') }}"></script>

</head>

<body>

    <x-adminsidebar></x-adminsidebar>

    <div class="crud-container">
        <h2>
            Theme Management
            <button class="add-button" onclick="openAddModal()"><i class="fas fa-plus"></i>Add Theme</button>
        </h2>

        <!-- Sample Theme Items (Replace with actual data from your database) -->
        <div class="theme-item">
            <div>
                <strong id="themeName1">Theme 1</strong>
            </div>
            <div class="theme-item-actions">
                <button class="view-button" onclick="openViewModal('Theme 1')"><i class="fas fa-eye"></i></button>
                <button class="edit-button" onclick="editModalOverlay('Theme 1', 'themeName1')">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button class="delete-button"><i class="fas fa-times"></i></button>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div class="modal-overlay" id="editModalOverlay"></div>
<div class="modal" id="editThemeModal">
    <h2>Edit Theme</h2>
    <input type="text" id="newThemeName" placeholder="Enter new theme name">
    <button class="edit-button" onclick="editTheme()">Edit</button>
    <button class="cancel" onclick="closeEditThemeModal()">Cancel</button>
</div>

    <!-- Add Theme Modal -->
    <div class="modal-overlay" id="addModalOverlay"></div>
    <div class="modal" id="addModal">
        <h2>Add Theme</h2>
        <input type="text" id="addThemeName" placeholder="Enter theme name">
        <button class="add-button">Add</button>
        <button class="cancel" onclick="closeAddModal()">Cancel</button>
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
            <div class="theme-item">
                <div>
                    <strong>Question 1</strong>
                </div>
                <div class="theme-item-actions">
                    <button class="view-button" onclick="openQuestionModal('Question 1')"><i
                            class="fas fa-eye"></i></button>
                    <button class="edit-button" onclick="openEditModal('Question 1')"><i
                            class="fas fa-pencil-alt"></i></button>
                    <button class="delete-button"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editQuestionModalOverlay"></div>
    <div class="modal" id="editQuestionModal">
        <h2>Edit Question</h2>
        <input type="text" id="editQuestionName" placeholder="Enter new question name">
        <button class="edit-button" onclick="editQuestion()">Edit</button>
        <button class="cancel" onclick="closeEditModal()">Cancel</button>
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
                    <button class="edit-button" onclick="openEditAnswerModal()"><i
                            class="fas fa-pencil-alt"></i></button>
                    <button class="delete-button"><i class="fas fa-times"></i></button>
                </div>
                <!-- Add x and checkmark buttons here -->
                <div class="extra-buttons">
                    <button class="extra-button x-button" onclick="toggleButton('x', 1)"><i
                            class="fas fa-times"></i></button>
                    <button class="extra-button check-button" onclick="toggleButton('check', 1)"><i
                            class="fas fa-check"></i></button>
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
