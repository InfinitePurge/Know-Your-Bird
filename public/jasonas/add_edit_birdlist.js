// Add Bird Javascript
document.addEventListener("DOMContentLoaded", function() {
    var fileList = [];
    var fileInput = document.getElementById('birdImages');
    var fileListContainer = document.getElementById('file-list');

    window.handleFiles = function(selectedFiles) {
        if (window.currentFileIndexToReplace !== undefined) {
            console.log("Currently replacing a file, skipping handleFiles call.");
            return;
        }
        console.log("Handling files:", selectedFiles);

        Array.from(selectedFiles).forEach(file => {
            if (!fileList.some(f => f.name === file.name && f.size === file.size)) {
                console.log("Adding new file:", file.name);
                fileList.push(file);
            } else {
                console.log("File already in list:", file.name);
            }
        });
        updateFileListDisplay();
    };

    // Function to handle file replacements
    window.replaceFile = function(index) {
        window.currentFileIndexToReplace = index; // Set the current file index to replace
        console.log("Set to replace file at index:", index);
        fileInput.click(); // Open the file dialog
    };

    // Event listener for file input change
    fileInput.addEventListener('change', function(event) {
        console.log("File input changed. Current replace index:", window.currentFileIndexToReplace);
        if (window.currentFileIndexToReplace !== undefined && event.target.files.length > 0) {
            console.log("Replacing file at index:", window.currentFileIndexToReplace);
            fileList[window.currentFileIndexToReplace] = event.target.files[0];
            console.log(`File at index ${window.currentFileIndexToReplace} replaced with`, event
                .target.files[0].name);
            window.currentFileIndexToReplace = undefined; // Reset the index after replacement
        } else {
            console.log("No replace index set, handling files as new.");
            handleFiles(event.target.files);
        }
        updateFileListDisplay();
        fileInput.value = ''; // Clear the file input for future use
    });

    // Function to remove a file from the fileList
    window.removeFile = function(index) {
        console.log("Removing file at index:", index);
        fileList.splice(index, 1);
        updateFileListDisplay();
    };

    // Function to update the display of the fileList
    function updateFileListDisplay() {
        console.log("Updating file list display.");
        fileListContainer.innerHTML = '';
        fileList.forEach((file, index) => {
            var fileRow = document.createElement('div');
            fileRow.className = 'file-row';
            fileRow.innerHTML = `
        <span class="file-name">${file.name} (${(file.size / 1024).toFixed(2)} KB)</span>
        <span class="file-actions">
            <button type="button" class="btn btn-secondary btn-sm replace-btn" onclick="replaceFile(${index});">Replace</button>
            <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeFile(${index});">✖</button>
        </span>
    `;
            fileListContainer.appendChild(fileRow);
        });
    }

    window.submitForm = function() {
        if (fileList.length === 0) {
            alert('Please select one or more files.');
            return;
        }

        var formData = new FormData();
        fileList.forEach((file) => {
            formData.append('images[]', file, file.name);
        });

        // Append other form data
        formData.append('birdName', document.getElementById('birdName').value);
        formData.append('birdContinent', document.getElementById('birdContinent').value);
        formData.append('birdMiniText', document.getElementById('birdMiniText').value);

        // Append tags
        document.querySelectorAll('input[name="tags[]"]:checked').forEach(tag => {
            formData.append('tags[]', tag.value);
        });

        console.log("Submitting form with AJAX");

        fetch('/admin/bird/add', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
            })
            .then(response => {
                console.log("Received response:", response);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };
});
//End of Add Bird Javascript
