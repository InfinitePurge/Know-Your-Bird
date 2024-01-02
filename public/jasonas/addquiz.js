function editModalOverlay(themeName, themeId) {
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

function openQuestionModal(questionText) {
    document.getElementById("questionContainer").innerText = questionText;
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
function openViewModal(currentThemeName) {
    // Set the current theme name in the view modal
    document.getElementById("viewThemeName").innerText = currentThemeName;

    // Show the modal overlay and view modal
    document.getElementById("viewModalOverlay").style.display = "block";
    document.getElementById("viewModal").style.display = "block";
}

// Function to close the view modal
function closeViewModal() {
    // Hide the modal overlay and view modal
    document.getElementById("viewModalOverlay").style.display = "none";
    document.getElementById("viewModal").style.display = "none";
}
