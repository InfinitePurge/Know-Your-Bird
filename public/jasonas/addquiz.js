setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.style.display = 'none';
    });
}, 6000);

function editModalOverlay(quizId, currentTitle) {
    document.getElementById("editThemeId").value = quizId;
    document.getElementById("newThemeName").value = currentTitle;
    document.getElementById("editModalOverlay").style.display = "block";
    document.getElementById("editThemeModal").style.display = "block";
}

function closeEditThemeModal() {
    // Hide the modal overlay and edit theme modal
    document.getElementById("editModalOverlay").style.display = "none";
    document.getElementById("editThemeModal").style.display = "none";
}

function openEditAnswerModal() {
    // Your logic to open the edit answer modal
    document.getElementById("editAnswerModalOverlay").style.display = "block";
    document.getElementById("editAnswerModal").style.display = "block";
}

function closeEditAnswerModal() {
    // Your logic to close the edit answer modal
    document.getElementById("editAnswerModalOverlay").style.display = "none";
    document.getElementById("editAnswerModal").style.display = "none";
}

function openAddAnswerModal() {
    document.getElementById("addAnswerModalOverlay").style.display = "block";
    document.getElementById("addAnswerModal").style.display = "block";
}

function closeAddAnswerModal() {
    document.getElementById("addAnswerModalOverlay").style.display = "none";
    document.getElementById("addAnswerModal").style.display = "none";
}

function openViewQuestionModal(questionText) {
    document.getElementById("questionContainer").innerText = questionText;
    document.getElementById("questionModalOverlay").style.display = "block";
    document.getElementById("questionModal").style.display = "block";
}

// Function to close the edit modal
function closeEditModal() {
    // Hide the modal overlay and edit modal
    document.getElementById("editQuestionModalOverlay").style.display = "none";
    document.getElementById("editQuestionModal").style.display = "none";
}

let activeButton = null;

function toggleButton(button) {
    // If the clicked button is already active, deactivate it
    if (button === activeButton) {
        document.querySelector(`.${button}-button`).style.backgroundColor =
            "grey";
        activeButton = null;
    } else {
        // Deactivate the active button, if any
        if (activeButton) {
            document.querySelector(
                `.${activeButton}-button`
            ).style.backgroundColor = "grey";
        }

        // Activate the clicked button
        document.querySelector(`.${button}-button`).style.backgroundColor =
            button === "x" ? "red" : "green";
        activeButton = button;
    }
}

function openAddQuestionModal() {
    // Show the modal overlay and add question modal
    document.getElementById("addQuestionModalOverlay").style.display = "block";
    document.getElementById("addQuestionModal").style.display = "block";
}

function closeAddQuestionModal() {
    // Hide the modal overlay and add question modal
    document.getElementById("addQuestionModalOverlay").style.display = "none";
    document.getElementById("addQuestionModal").style.display = "none";
}

function openQuestionModal(questionText, encryptedQuestionId) {
    document.getElementById("questionContainer").innerText = questionText;

    // Fetch answers for the question
    fetch(`/addquiz/questions/${encryptedQuestionId}/answers`)
        .then(response => response.json())
        .then(answers => {
            let answersHtml = answers.map((answer, index) => 
                `<div class="theme-item">
                    <div><strong>${answer.text}</strong></div>
                    <div class="theme-item-actions">
                        <button class="edit-button" onclick="openEditAnswerModal('${answer.encrypted_id}')" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                        <button class="delete-button" onclick="confirmDeleteAnswer('${answer.encrypted_id}')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="extra-buttons">
                        <button class="extra-button x-button" onclick="toggleButton('x', ${index})" title="Value:"><i class="fas fa-times"></i></button>
                        <button class="extra-button check-button" onclick="toggleButton('check', ${index})" title="Value:"><i class="fas fa-check"></i></button>
                    </div>
                </div>`
            ).join('');
            document.getElementById("answersContainer").innerHTML = answersHtml;
        })
        .catch(error => console.error('Error:', error));

    document.getElementById("questionModalOverlay").style.display = "block";
    document.getElementById("questionModal").style.display = "block";
}

function closeQuestionModal() {
    document.getElementById("questionModalOverlay").style.display = "none";
    document.getElementById("questionModal").style.display = "none";
}
// Function to open the edit modal with the current theme name
function openEditModal(currentName) {
    // Set the current name in the input field
    document.getElementById("editQuestionName").value = currentName;

    // Show the modal overlay and edit modal
    document.getElementById("editQuestionModalOverlay").style.display = "block";
    document.getElementById("editQuestionModal").style.display = "block";
}

// Function to close the edit modal
function closeEditModal() {
    // Hide the modal overlay and edit modal
    document.getElementById("editQuestionModalOverlay").style.display = "none";
    document.getElementById("editQuestionModal").style.display = "none";
}

// Function to open the add modal
function openAddModal() {
    // Show the modal overlay and add modal
    document.getElementById("addModalOverlay").style.display = "block";
    document.getElementById("addModal").style.display = "block";
}

// Function to close the add modal
function closeAddModal() {
    // Hide the modal overlay and add modal
    document.getElementById("addModalOverlay").style.display = "none";
    document.getElementById("addModal").style.display = "none";
}

// Function to open the view modal with the current theme name
function openViewModal(themeId, themeName) {
    document.getElementById("viewThemeName").innerText = themeName;

    fetch('/quiz/questions/' + themeId)
        .then(response => response.json())
        .then(questions => {
            let questionsContainer = document.getElementById("questionsContainer");
            questionsContainer.innerHTML = '';

            questions.forEach(question => {
                let div = document.createElement('div');
                div.className = 'theme-item';
                div.innerHTML = `
                    <div><strong>${question.text}</strong></div>
                    <div class="theme-item-actions">
                        <button class="view-button" onclick="openQuestionModal('${question.text}', '${question.encrypted_id}')"><i class="fas fa-eye"></i></button>
                        <button class="edit-button" onclick="openEditQuestionModal('${question.encrypted_id}', '${question.text}')"><i class="fas fa-pencil-alt"></i></button>
                        <button class="delete-button" onclick="confirmDeleteQuestion('${question.encrypted_id}')"><i class="fas fa-times"></i></button>
                    </div>`;
                questionsContainer.appendChild(div);
            });
        })
        .catch(error => console.error('Error:', error));

    document.getElementById("viewModalOverlay").style.display = "block";
    document.getElementById("viewModal").style.display = "block";
}


// Function to close the view modal
function closeViewModal() {
    // Hide the modal overlay and view modal
    document.getElementById("viewModalOverlay").style.display = "none";
    document.getElementById("viewModal").style.display = "none";
}
