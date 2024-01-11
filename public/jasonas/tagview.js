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

// Prefix delete form submit confirmation
function deletePrefix(prefixId) {
    if (confirm('Are you sure you want to delete this prefix?')) {
        document.getElementById('deleteForm' + prefixId).submit();
    }
}

// Null Tag edit form open
function openEditForm(tagId) {
    var editForms = document.querySelectorAll('[id^="editTagForm"]');
    editForms.forEach(function(form) {
        form.classList.add('hidden');
    });
    document.getElementById('editTagForm' + tagId).classList.remove('hidden');
}

// Null Tag edit form close
function closeEditForm(tagId) {
    document.getElementById('editTagForm' + tagId).classList.add('hidden');
}

// Prefix edit form open
var openPrefixFormId = null;

function openPrefixEditForm(prefixId, prefixName) {
    var editFormDiv = document.getElementById("editPrefixForm" + prefixId);
    
    if (openPrefixFormId !== null) {
        var previousFormDiv = document.getElementById("editPrefixForm" + openPrefixFormId);
        previousFormDiv.classList.add("hidden");
    }
    
    editFormDiv.classList.remove("hidden");
    var editInput = document.getElementById("editPrefixName" + prefixId);
    editInput.value = prefixName;
    
    openPrefixFormId = prefixId;
}

// Prefix edit form close
function closePrefixForm(prefixId) {
    var editFormDiv = document.getElementById("editPrefixForm" + prefixId);
    if (editFormDiv) {
        editFormDiv.classList.add("hidden");
    }
}

 $(document).ready(function () {
     // Handle the "Select All" checkboxes for each table
     $(".selectAllCheckbox").change(function () {
         // Get the checkboxes within the same table as the clicked "Select All" checkbox
         var checkboxes = $(this).closest("table").find("tbody :checkbox");

         // Set their checked state based on the clicked "Select All" checkbox
         checkboxes.prop("checked", $(this).prop("checked"));
     });
 });