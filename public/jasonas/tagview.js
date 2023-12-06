

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
