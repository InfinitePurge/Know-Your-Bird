setTimeout(function () {
    let alerts = document.querySelectorAll(".alert");
    alerts.forEach(function (alert) {
        alert.style.display = "none";
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

function openEditAnswerModal(encryptedId, currentText) {
    // Store the encrypted ID in the hidden input field
    document.getElementById('editAnswerId').value = encryptedId;
    document.getElementById('editAnswerText').value = currentText;

    // Open the modal
    document.getElementById("editAnswerModalOverlay").style.display = "block";
    document.getElementById("editAnswerModal").style.display = "block";
}


function editAnswer() {
    var encryptedId = document.getElementById('editAnswerId').value;
    var answerText = document.getElementById('editAnswerText').value;

    // AJAX request to send the data to the server
    fetch('/addquiz/editAnswer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token
        },
        body: JSON.stringify({ id: encryptedId, answer: answerText })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        closeEditAnswerModal();

        // Reload the page
        location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function closeEditAnswerModal() {
    // Your logic to close the edit answer modal
    document.getElementById("editAnswerModalOverlay").style.display = "none";
    document.getElementById("editAnswerModal").style.display = "none";
}

function openAddAnswerModal(questionId) {
    document.getElementById("questionIdField").value = questionId;
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

function toggleButton(button, index) {
    const xButton = document.querySelector(`.x-button-${index}`);
    const checkButton = document.querySelector(`.check-button-${index}`);

    // If the clicked button is already active, deactivate it
    if (button === activeButton) {
        xButton.style.backgroundColor = "grey";
        checkButton.style.backgroundColor = "grey";
        activeButton = null;
    } else {
        // Deactivate the active button, if any
        if (activeButton) {
            document.querySelector(
                `.${activeButton}-button-${index}`
            ).style.backgroundColor = "grey";
        }

        // Activate the clicked button
        xButton.style.backgroundColor = button === "x" ? "red" : "grey";
        checkButton.style.backgroundColor =
            button === "check" ? "green" : "grey";
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
        .then((response) => response.json())
        .then((answers) => {
            let answersHtml = answers
                .map(
                    (answer, index) =>
                    `<div class="theme-item">
                        <div><strong>${answer.text}</strong></div>
                            <div class="theme-item-actions">
                                <button class="edit-button" onclick="openEditAnswerModal('${answer.encrypted_id}', '${answer.text}')"><i class="fas fa-pencil-alt"></i></button>
                                <button class="delete-button" onclick="confirmDeleteAnswer('${answer.encrypted_id}', '${questionText}', '${encryptedQuestionId}')"><i class="fas fa-times"></i></button>
                            </div>
                        <div class="extra-buttons">
                            <button class="extra-button x-button-${index}" onclick="toggleButton('x', ${index})" style="background-color: ${answer.isCorrect ? 'grey' : 'red'};" title="Value:"><i class="fas fa-times"></i></button>
                            <button class="extra-button check-button-${index}" onclick="toggleButton('check', ${index})" style="background-color: ${answer.isCorrect ? 'green' : 'grey'};" title="Value:"><i class="fas fa-check"></i></button>
                        </div>
                    </div>`
                )
                .join("");
            document.getElementById("answersContainer").innerHTML = answersHtml;
        })
        .catch((error) => console.error("Error:", error));

    document.getElementById("questionModalOverlay").style.display = "block";
    document.getElementById("questionModal").style.display = "block";
}

function confirmDeleteAnswer(
    encryptedAnswerId,
    questionText,
    encryptedQuestionId
) {
    if (confirm("Are you sure you want to delete this answer?")) {
        fetch(`/addquiz/deleteAnswer/${encryptedAnswerId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then(() => {
                // Call openQuestionModal again to refresh the answers list
                openQuestionModal(questionText, encryptedQuestionId);
            })
            .catch((error) => console.error("Error:", error));
    }
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

    fetch("/quiz/questions/" + themeId)
        .then((response) => response.json())
        .then((questions) => {
            let questionsContainer =
                document.getElementById("questionsContainer");
            questionsContainer.innerHTML = "";

            questions.forEach((question) => {
                let div = document.createElement("div");
                div.className = "theme-item";
                div.innerHTML = `
                    <div><strong>${question.text}</strong></div>
                    <div class="theme-item-actions">
                        <button class="view-button" onclick="openQuestionModal('${question.text}', '${question.encrypted_id}')"><i class="fas fa-eye"></i></button>
                        <button class="edit-button" onclick="openEditQuestionModal('${question.encrypted_id}', '${question.text}')"><i class="fas fa-pencil-alt"></i></button>
                        <button class="delete-button" onclick="confirmDeleteQuestion('${question.encrypted_id}', '${themeId}', '${themeName}')"><i class="fas fa-times"></i></button>
                    </div>`;
                questionsContainer.appendChild(div);
            });
        })
        .catch((error) => console.error("Error:", error));

    document.getElementById("viewModalOverlay").style.display = "block";
    document.getElementById("viewModal").style.display = "block";
}

function confirmDeleteQuestion(encryptedQuestionId, themeId, themeName) {
    if (confirm("Are you sure you want to delete this question?")) {
        fetch(`/addquiz/deleteQuestion/${encryptedQuestionId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                let successDiv = document.getElementById("successMessage");
                successDiv.innerHTML = ""; // Clear previous messages
                let message = document.createElement("h4");
                message.style.color = "rgb(43, 255, 0)"; // Set the style
                message.innerText = "Question deleted successfully.";
                successDiv.appendChild(message);
                successDiv.style.display = "block";
                openViewModal(themeId, themeName);
                setTimeout(() => {
                    successDiv.style.display = "none";
                }, 3000);
            })
            .catch((error) => console.error("Error:", error));
    }
}

function editQuestion() {
    let encryptedQuestionId = document.getElementById("editQuestionId").value;
    let newQuestionText = document.getElementById("editQuestionName").value;

    fetch("/addquiz/editQuestion", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            id: encryptedQuestionId,
            question: newQuestionText,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            // closeEditModal();
            location.reload();
        })
        .catch((error) => console.error("Error:", error));
}

function openEditQuestionModal(encryptedQuestionId, currentText) {
    document.getElementById("editQuestionId").value = encryptedQuestionId;
    document.getElementById("editQuestionName").value = currentText;
    document.getElementById("editQuestionModalOverlay").style.display = "block";
    document.getElementById("editQuestionModal").style.display = "block";
}

// Function to close the view modal
function closeViewModal() {
    // Hide the modal overlay and view modal
    document.getElementById("viewModalOverlay").style.display = "none";
    document.getElementById("viewModal").style.display = "none";
}
