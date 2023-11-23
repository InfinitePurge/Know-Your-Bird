$(document).ready(function () {
  var allBirds = $('.bird-card');
  var itemsPerPage = 15;
  var currentPage = 1;
  var maxPageNumbersToShow = 10;

  function renderPagination() {
      var totalPages = Math.ceil(allBirds.length / itemsPerPage);
      var paginationUl = $('.pagination ul');
      paginationUl.find('li:not(.prev, .next)').remove(); // Clear existing

      var startPage = Math.max(currentPage - Math.floor(maxPageNumbersToShow / 2), 1);
      var endPage = Math.min(startPage + maxPageNumbersToShow - 1, totalPages);

      if (endPage - startPage < maxPageNumbersToShow) {
          startPage = Math.max(endPage - maxPageNumbersToShow + 1, 1);
      }

      for (var i = startPage; i <= endPage; i++) {
          $('<li>', {
              class: currentPage === i ? 'active' : '',
              html: $('<a>', {
                  href: '#',
                  text: i,
                  click: function (e) {
                      e.preventDefault();
                      currentPage = parseInt($(this).text());
                      paginateBirds();
                  }
              })
          }).insertBefore(paginationUl.find('.next'));
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
          currentPage = 1;
          paginateBirds();
      }
  });

  $('.pagination .next').on('click', function (e) {
      e.preventDefault();
      var lastPage = Math.ceil(allBirds.length / itemsPerPage);
      if (currentPage !== lastPage) {
          currentPage = lastPage;
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

  paginateBirds(); // Initial call to set up pagination
});