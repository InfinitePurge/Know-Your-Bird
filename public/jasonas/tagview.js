

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


// Null Tag edit form
function openEditForm() {
    document.getElementById("editTagForm").classList.remove("hidden");
}

function closeEditForm() {
    document.getElementById("editTagForm").classList.add("hidden");
}

// Prefix edit form
function openPrefixEditForm() {
    document.getElementById("editPrefixForm").classList.remove("hidden");
}

function closePrefixForm() {
    document.getElementById("editPrefixForm").classList.add("hidden");
}