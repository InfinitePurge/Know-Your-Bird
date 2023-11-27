// $('#editBirdModal').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget); // Button that triggered the modal
//     var birdId = button.data('bird-id'); // Extract info from data-* attributes
//     var birdDescription = button.data('bird-description'); // Assuming this holds the description

//     // Update the form action
//     var editForm = $(this).find('form');
//     var editAction = 'your_php_script.php?id=' + birdId; // Update with your actual script
//     editForm.attr('action', editAction);
//     editForm.find('input[name="_method"]').val('PUT');
// });


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
        allBirds.hide();
        var filteredBirds = allBirds.filter('[data-continent="' + selectedKilme + '"]');
        filteredBirds.show();
        allBirds = filteredBirds;
        currentPage = 1;
        paginateBirds();
    });

    paginateBirds();
});
