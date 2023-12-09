var dropdownElementList = [].slice.call(
    document.querySelectorAll(".dropdown-toggle")
);
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    var dropdown = new bootstrap.Dropdown(dropdownToggleEl);
    
    return dropdown;
});

var dropdownElementList = [].slice.call(
    document.querySelectorAll(".dropdown-toggle")
);

var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl, {
        popperConfig: function (defaultBsPopperConfig) {
            var bsPopperConfig = {
                ...defaultBsPopperConfig,
                modifiers: [
                    {
                        name: "flip",
                        options: {
                            fallbackPlacements: ["bottom"],
                        },
                    },
                ],
            };
            return bsPopperConfig;
        },
    });
});

// Tag delete form submit confirmation
function deleteTag(tagId) {
    if (confirm('Are you sure you want to delete this tag?')) {
        document.getElementById('deleteTagForm' + tagId).submit();
    }
}

// Null Tag edit form open
function openEditForm() {
    document.getElementById("editTagForm").classList.remove("hidden");
}

// Null Tag edit form close
function closeEditForm() {
    document.getElementById("editTagForm").classList.add("hidden");
}

// Prefix edit form open
function openPrefixEditForm(prefixId, prefixName) {
    var editFormDiv = document.getElementById("editPrefixForm" + prefixId);
    editFormDiv.classList.remove("hidden");
    var editInput = editFormDiv.querySelector("#editPrefixName");
    editInput.value = prefixName;
    var form = editFormDiv.querySelector("form");
    var baseUrl = form.dataset.baseurl;
    form.action = baseUrl;
}

// Prefix edit form close
function closePrefixForm(prefixId) {
    var editFormDiv = document.getElementById("editPrefixForm" + prefixId);
    if (editFormDiv) {
        editFormDiv.classList.add("hidden");
    }
}