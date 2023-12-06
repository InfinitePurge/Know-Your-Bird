

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
            // Use a modified popper config to force the dropdown to be placed at the bottom
            var bsPopperConfig = {
                ...defaultBsPopperConfig,
                modifiers: [
                    {
                        name: "flip",
                        options: {
                            fallbackPlacements: ["bottom"], // Only allow 'bottom' as a fallback placement
                        },
                    },
                ],
            };
            return bsPopperConfig;
        },
    });
});
