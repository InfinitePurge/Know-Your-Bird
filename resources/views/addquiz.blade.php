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

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .crud-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }

        h2 {
            color: #333;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .theme-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
        }

        .theme-item-actions {
            display: flex;
        }

        .theme-item-actions button {
            margin-left: 10px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            display: flex;
            align-items: center;
            background-color: transparent;
            /* Set background color to transparent */
        }

        .view-button i {
            color: #2196f3;
            /* Blue color for view */
        }

        .edit-button i {
            color: #ffd600;
            /* Yellow color for edit */
            cursor: pointer;
        }

        .delete-button i {
            color: #ff5252;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal button {
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .modal button.cancel {
            background-color: #ccc;
            margin-right: 10px;
        }

        .add-button,
        .edit-button {
            cursor: pointer;
        }

        .add-button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            padding: 10px 16px;
            border-radius: 4px;
            border: none;
            display: flex;
            align-items: center;
        }

        #addModal button.add-button,
        #addModal button.cancel {
            display: inline-block;
            /* Make the buttons inline */
            margin-top: 10px;
            /* Add some space between the input field and buttons */
            padding: 10px 16px;
            /* Adjust padding for a slightly bigger button */
            border-radius: 4px;
            /* Border radius for rounded corners */
            border: none;
            /* Remove borders */
            cursor: pointer;
        }

        #addModal button.add-button {
            background-color: #4caf50;
            /* Green color */
            color: #fff;
            /* White text color */
        }

        #addModal button.cancel {
            background-color: #ccc;
            color: #fff;
            /* White text color */
            margin-left: 10px;
            /* Add margin to separate buttons */
        }

        /* Custom styles for the View Modal */
        #viewModal {
            width: 50%;
            height: 50%;
        }

        #viewModal .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #333;
            background: none;
            border: none;
        }

        #viewThemeNameContainer {
            display: flex;
            align-items: center;
        }

        #viewThemeNameContainer strong {
            margin-right: 5px;
            /* Optional: Add some spacing between the strong and the p element */
        }

        #viewModal {
            width: 50%;
            height: 50%;
        }

        #questionModal {
            width: 40%;
            height: 45%;
        }

        #questionContainer {
            /* Add any styles as needed for question content */
        }

        /* Additional styles for the new modal */
        #questionModal .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #333;
            background: none;
            border: none;
        }
    </style>
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
                <button class="edit-button" onclick="openEditModal('Theme 1', 'themeName1')"><i
                        class="fas fa-pencil-alt"></i></button>
                <button class="delete-button"><i class="fas fa-times"></i></button>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div class="modal-overlay" id="editModalOverlay"></div>
    <div class="modal" id="editThemeModal">
        <h2>Edit Theme</h2>
        <input type="text" id="newThemeName" placeholder="Enter new theme name">
        <button class="edit-button">Edit</button>
        <button class="cancel" onclick="closeEditModal()">Cancel</button>
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
        <button class="close-btn" onclick="closeViewModal()">&times;</button>
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


    <!-- New Question Modal -->
    <div class="modal-overlay" id="questionModalOverlay"></div>
    <div class="modal" id="questionModal">
        <h2>View Question</h2>
        <button class="close-btn" onclick="closeQuestionModal()">&times;</button>
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
                    <button class="edit-button"><i class="fas fa-pencil-alt"></i></button>
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

        <script>
            function openViewQuestionModal(questionText) {
                document.getElementById('questionContainer').innerText = questionText;
                document.getElementById('questionModalOverlay').style.display = 'block';
                document.getElementById('questionModal').style.display = 'block';
            }

            // Function to close the edit modal
            function closeEditModal() {
                // Hide the modal overlay and edit modal
                document.getElementById('editQuestionModalOverlay').style.display = 'none';
                document.getElementById('editQuestionModal').style.display = 'none';
            }

            let activeButton = null;

            function toggleButton(button) {
                // If the clicked button is already active, deactivate it
                if (button === activeButton) {
                    document.querySelector(`.${button}-button`).style.backgroundColor = 'grey';
                    activeButton = null;
                } else {
                    // Deactivate the active button, if any
                    if (activeButton) {
                        document.querySelector(`.${activeButton}-button`).style.backgroundColor = 'grey';
                    }

                    // Activate the clicked button
                    document.querySelector(`.${button}-button`).style.backgroundColor = button === 'x' ? 'red' : 'green';
                    activeButton = button;
                }
            }

            function openQuestionModal(questionText) {
                document.getElementById('questionContainer').innerText = questionText;
                document.getElementById('questionModalOverlay').style.display = 'block';
                document.getElementById('questionModal').style.display = 'block';
            }

            function closeQuestionModal() {
                document.getElementById('questionModalOverlay').style.display = 'none';
                document.getElementById('questionModal').style.display = 'none';
            }
            // Function to open the edit modal with the current theme name
            function openEditModal(currentName) {
                // Set the current name in the input field
                document.getElementById('editQuestionName').value = currentName;

                // Show the modal overlay and edit modal
                document.getElementById('editQuestionModalOverlay').style.display = 'block';
                document.getElementById('editQuestionModal').style.display = 'block';
            }

            // Function to close the edit modal
            function closeEditModal() {
                // Hide the modal overlay and edit modal
                document.getElementById('editQuestionModalOverlay').style.display = 'none';
                document.getElementById('editQuestionModal').style.display = 'none';
            }

            // Function to open the add modal
            function openAddModal() {
                // Show the modal overlay and add modal
                document.getElementById('addModalOverlay').style.display = 'block';
                document.getElementById('addModal').style.display = 'block';
            }

            // Function to close the add modal
            function closeAddModal() {
                // Hide the modal overlay and add modal
                document.getElementById('addModalOverlay').style.display = 'none';
                document.getElementById('addModal').style.display = 'none';
            }

            // Function to open the view modal with the current theme name
            function openViewModal(currentThemeName) {
                // Set the current theme name in the view modal
                document.getElementById('viewThemeName').innerText = currentThemeName;

                // Show the modal overlay and view modal
                document.getElementById('viewModalOverlay').style.display = 'block';
                document.getElementById('viewModal').style.display = 'block';
            }

            // Function to close the view modal
            function closeViewModal() {
                // Hide the modal overlay and view modal
                document.getElementById('viewModalOverlay').style.display = 'none';
                document.getElementById('viewModal').style.display = 'none';
            }
        </script>

</body>

</html>
