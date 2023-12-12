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

   var selectedKilmes = [];
   var selectedPrefixes = [];
   var selectedTags = [];
   var selectedTagNulls = [];
    var allBirds = $(".bird-card");
    var itemsPerPage = 15;
    var currentPage = 1;
    var maxPageNumbersToShow = 10;


    function debounce(func, wait, immediate) {
        var timeout;
        return function () {
            var context = this,
                args = arguments;
            var later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Debounced version of filterBirds
    var debouncedFilterBirds = debounce(function () {
        filterBirds();
    }, 1); // Wait for 250 ms before invoking again

    function addFilterTag(category, value, arrayName) {
        // Create the tag element
        var tag = $("<span>").addClass("filter-tag").text(value);
        var closeBtn = $("<button>").text("x").addClass("close-filter");
        tag.append(closeBtn);
        $(".filter-tags-container").append(tag);

        closeBtn.on("click", function () {
            // Correctly reference the corresponding array based on category
            var filterArray = (category === "Kilmes") ? selectedKilmes :
                              (category === "Prefixes") ? selectedPrefixes :
                              (category === "Tags") ? selectedTags :
                              selectedTagNulls; // default to selectedTagNulls

            filterArray = filterArray.filter(function (item) {
                return item !== value;
            });

            // Update the global array
            if (category === "Kilmes") selectedKilmes = filterArray;
            else if (category === "Prefixes") selectedPrefixes = filterArray;
            else if (category === "Tags") selectedTags = filterArray;
            else selectedTagNulls = filterArray;

            tag.remove();
            debouncedFilterBirds();
        });
    }


    function filterBirds() {
        $(".bird-card").hide();

        // Show only the cards with the selected kilmes
        selectedKilmes.forEach(function (selectedKilme) {
            $('.bird-card[data-continent="' + selectedKilme + '"]').show();
        });

        // Show only the cards with the selected prefixes
        selectedPrefixes.forEach(function (selectedPrefix) {
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
        });

        // Show only the cards with the selected tags
        selectedTags.forEach(function (selectedTag) {
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
        });

        // Show only the cards with the selected tag nulls
        selectedTagNulls.forEach(function (selectedTagNull) {
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
        });

        renderPagination();
    }

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
    $("#salisDropdown").on("click", ".DropDownText", function () {
        var selectedKilme = $(this).text();
        selectedKilmes.push(selectedKilme);
        addFilterTag("Kilmes", selectedKilme, "selectedKilmes");
        filterBirds();
        debouncedFilterBirds();
    });

    // Prefix Dropdown Click Event
    $("#prefixDropdown").on("click", ".DropDownTextPrefix", function () {
        var selectedPrefix = $(this).text().trim();
        selectedPrefixes.push(selectedPrefix);
        addFilterTag("Prefixes", selectedPrefix, "selectedPrefixes");
        filterBirds();
        debouncedFilterBirds();
    });

    // Tag Dropdown Click Event
    $("#TagDropdown").on("click", ".DropDownTextTag", function () {
        var selectedTag = $(this).text().trim();
        selectedTags.push(selectedTag);
        addFilterTag("Tags", selectedTag, "selectedTags");
        filterBirds();
        debouncedFilterBirds();
    });

    // TagNull Dropdown Click Event
    $("#TagNullDropdown").on("click", ".DropDownTextTagNull", function () {
        var selectedTagNull = $(this).text().trim();
        selectedTagNulls.push(selectedTagNull);
        addFilterTag("TagNulls", selectedTagNull, "selectedTagNulls");
        filterBirds();
        debouncedFilterBirds();
    });
});
