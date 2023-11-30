$(document).ready(function () {
    $("#kilmeButton").click(function () {
        $("#salisDropdown").toggle();
    });
});

$(document).ready(function () {
    var allBirds = $('.bird-card');
    var itemsPerPage = 15;
    var currentPage = 1;
    var maxPageNumbersToShow = 10;

    function createPageItem(page, isDisabled) {
        var liClass = (page === currentPage && !isDisabled) ? 'active' : '';
        var aClass = isDisabled ? 'disabled' : '';
        var aClick = isDisabled ? null : function (e) {
            e.preventDefault();
            currentPage = parseInt($(this).text());
            paginateBirds();
        };

        return $('<li>', {
            class: liClass,
            html: $('<a>', {
                href: '#',
                text: page,
                class: aClass,
                click: aClick
            })
        });
    }

    $('#clearFilter').on('click', function () {
        window.location.reload();
    });

    function createPageItem(page, isDisabled) {
        var liClass = (page === currentPage && !isDisabled) ? 'active' : '';
        var aClass = isDisabled ? 'disabled' : '';
        var aClick = isDisabled ? null : function (e) {
            e.preventDefault();
            currentPage = parseInt($(this).text());
            paginateBirds();
        };
    
        return $('<li>', {
            class: liClass,
            html: $('<a>', {
                href: '#',
                text: page,
                class: aClass,
                click: aClick
            })
        });
    }
    
    function renderPagination() {
        var totalPages = Math.ceil(allBirds.length / itemsPerPage);
        var paginationUl = $('.pagination ul');
        paginationUl.find('li:not(.prev, .next)').remove(); // Clear existing
    
        var startPage = Math.max(currentPage - Math.floor(maxPageNumbersToShow / 2), 1);
        var endPage = Math.min(startPage + maxPageNumbersToShow - 1, totalPages);
    
        if (endPage - startPage < maxPageNumbersToShow) {
            startPage = Math.max(endPage - maxPageNumbersToShow + 1, 1);
        }
    
        // Check and insert ellipses before page number 1 if needed
        if (startPage > 2) {
            paginationUl.find('.prev').after(createPageItem('...', true));
        }
        if (startPage > 1) {
            paginationUl.find('.prev').after(createPageItem(1));
        }
    
        for (var i = startPage; i <= endPage; i++) {
            paginationUl.find('.next').before(createPageItem(i));
        }
    
        // Check and insert ellipses before the last page if needed
        if (endPage < totalPages - 1) {
            paginationUl.find('.next').before(createPageItem('...', true));
        }
        if (endPage < totalPages) {
            paginationUl.find('.next').before(createPageItem(totalPages));
        }
    }

    function paginateBirds() {
        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;
        allBirds.hide().slice(startIndex, endIndex).show();
        renderPagination();
    }

    $('.pagination .prev').on('click', function (e) {
        e.preventDefault();
        if (currentPage !== 1) {
            currentPage--;
            paginateBirds();
        }
    });

    $('.pagination .next').on('click', function (e) {
        e.preventDefault();
        var lastPage = Math.ceil(allBirds.length / itemsPerPage);
        if (currentPage !== lastPage) {
            currentPage++;
            paginateBirds();
        }
    });

    $('.DropDownText').on('click', function () {
        var selectedKilme = $(this).text();
        $("#kilmeButton").text(selectedKilme); // Change Kilme button text
        $("#salisDropdown").hide(); // Hide the dropdown
        // Rest of your existing code...
        allBirds.hide();
        var filteredBirds = allBirds.filter('[data-continent="' + selectedKilme + '"]');
        filteredBirds.show();
        allBirds = filteredBirds;
        currentPage = 1;
        paginateBirds();
    });

    paginateBirds();
});
