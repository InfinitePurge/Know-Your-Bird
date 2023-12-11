$(document).ready(function () {
    // Toggle dropdowns for Kilme and Prefix
    $("#kilmeButton").click(function () {
        $("#salisDropdown").toggle();
    });
    $("#prefixButton").click(function () {
        $("#prefixDropdown").toggle();
    });
    $("#TagButton").click(function () {
        $("#TagDropdown").toggle();
    });
    $("#TagNullButton").click(function () {
        $("#TagNullDropdown").toggle();
    });

    var allBirds = $(".bird-card");
    var itemsPerPage = 15;
    var currentPage = 1;
    var maxPageNumbersToShow = 10;

    function createPageItem(page, isDisabled) {
        var liClass = page === currentPage && !isDisabled ? "active" : "";
        var aClass = isDisabled ? "disabled" : "";
        var aClick = isDisabled
            ? null
            : function (e) {
                  e.preventDefault();
                  currentPage = parseInt($(this).text());
                  paginateBirds();
              };

        return $("<li>", {
            class: liClass,
            html: $("<a>", {
                href: "#",
                text: page,
                class: aClass,
                click: aClick,
            }),
        });
    }

    function renderPagination() {
        var totalPages = Math.ceil(allBirds.length / itemsPerPage);
        var paginationUl = $(".pagination ul");
        paginationUl.find("li:not(.prev, .next)").remove(); // Clear existing

        var startPage = Math.max(
            currentPage - Math.floor(maxPageNumbersToShow / 2),
            1
        );
        var endPage = Math.min(
            startPage + maxPageNumbersToShow - 1,
            totalPages
        );

        if (endPage - startPage < maxPageNumbersToShow) {
            startPage = Math.max(endPage - maxPageNumbersToShow + 1, 1);
        }

        // Check and insert ellipses before page number 1 if needed
        if (startPage > 2) {
            paginationUl.find(".prev").after(createPageItem("...", true));
        }
        if (startPage > 1) {
            paginationUl.find(".prev").after(createPageItem(1));
        }

        for (var i = startPage; i <= endPage; i++) {
            paginationUl.find(".next").before(createPageItem(i));
        }

        // Check and insert ellipses before the last page if needed
        if (endPage < totalPages - 1) {
            paginationUl.find(".next").before(createPageItem("...", true));
        }
        if (endPage < totalPages) {
            paginationUl.find(".next").before(createPageItem(totalPages));
        }
    }

    function paginateBirds() {
        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;
        allBirds.hide().slice(startIndex, endIndex).show();
        renderPagination();
    }

    // Initialize Pagination
    paginateBirds();

    // Clear Filter Button
    $("#clearFilter").on("click", function () {
        window.location.reload();
    });

    // Pagination Buttons
    $(".pagination .prev").on("click", function (e) {
        e.preventDefault();
        if (currentPage !== 1) {
            currentPage--;
            paginateBirds();
        }
    });

    $(".pagination .next").on("click", function (e) {
        e.preventDefault();
        var lastPage = Math.ceil(allBirds.length / itemsPerPage);
        if (currentPage !== lastPage) {
            currentPage++;
            paginateBirds();
        }
    });

    // Kilme Dropdown Click Event
        // Attach a click event listener to the kilme dropdown items
        $(".DropDownText").on("click", function () {
            // Get the selected kilme value
            var selectedKilme = $(this).text();

            console.log("Selected Kilme:", selectedKilme);

            // Hide all bird cards
            $(".bird-card").hide();

            // Show only the cards with the selected kilme
            $('.bird-card[data-continent="' + selectedKilme + '"]').show();

            // Log the number of cards found
            var numCards = $(
                '.bird-card[data-continent="' + selectedKilme + '"]'
            ).length;
            console.log("Number of cards with selected Kilme:", numCards);

            // Hide the dropdown
            $("#salisDropdown").hide();

            // Update the button text to the selected option
            $("#kilmeButton").text(selectedKilme);

            return false;
        });

        // Prefix Dropdown Click Event
        $("#prefixDropdown").on("click", ".DropDownTextPrefix", function () {
            var selectedPrefix = $(this).text().trim(); // Get the text of the selected prefix
            console.log("Selected Prefix:", selectedPrefix);

            // Hide all bird cards
            $(".bird-card").hide();

            // Filter and show cards that contain the selected prefix in their tags
            $(".bird-card").each(function () {
                var hasPrefix =
                    $(this)
                        .find(".badge")
                        .filter(function () {
                            return $(this).text().includes(selectedPrefix);
                        }).length > 0;

                if (hasPrefix) {
                    $(this).show();
                }
            });

            // Hide the dropdown
            $("#prefixDropdown").hide();

            // Update the button text to the selected option
            $("#prefixButton").text(selectedPrefix);

            return false;
        });

        $("#TagDropdown").on("click", ".DropDownTextTag", function () {
            var selectedTag = $(this).text().trim(); // Get the text of the selected prefix
            console.log("Selected Tag:", selectedTag);

            // Hide all bird cards
            $(".bird-card").hide();

            // Filter and show cards that contain the selected prefix in their tags
            $(".bird-card").each(function () {
                var hasTag =
                    $(this)
                        .find(".badge")
                        .filter(function () {
                            return $(this).text().includes(selectedTag);
                        }).length > 0;

                if (hasTag) {
                    $(this).show();
                }
            });

            // Hide the dropdown
            $("#TagDropdown").hide();

            // Update the button text to the selected option
            $("#TagButton").text(selectedTag);

            return false;
        });

        $("#TagNullDropdown").on("click", ".DropDownTextTagNull", function () {
            var selectedTagNull = $(this).text().trim(); // Get the text of the selected prefix
            console.log("Selected Tag Null:", selectedTagNull);

            // Hide all bird cards
            $(".bird-card").hide();

            // Filter and show cards that contain the selected prefix in their tags
            $(".bird-card").each(function () {
                var hasTagNull =
                    $(this)
                        .find(".badge")
                        .filter(function () {
                            return $(this).text().includes(selectedTagNull);
                        }).length > 0;

                if (hasTagNull) {
                    $(this).show();
                }
            });

            // Hide the dropdown
            $("#TagNullDropdown").hide();

            // Update the button text to the selected option
            $("#TagNullButton").text(selectedTagNull);

            return false;
        });



});
