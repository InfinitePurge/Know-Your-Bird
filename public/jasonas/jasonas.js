
$('.pagination li').on('click', function(event) {
    event.preventDefault();
    var $this = $(this),
        $pagination = $this.parent(),
        $pages = $pagination.children(),
        $active = $pagination.find('.active');
    
    if($this.hasClass('prev')) {
      if ($pages.index($active) > 1) {
        $active.removeClass('active').prev().addClass('active');
      }
    } else if($this.hasClass('next')) {
      if ($pages.index($active) < $pages.length - 2) {
        $active.removeClass('active').next().addClass('active');
      }
    } else {
      $this.addClass('active').siblings().removeClass('active');
    }
    
    $active = $pagination.find('.active');
    
    $('.prev')[$pages.index($active) == 1 ? 'addClass' : 'removeClass']('disabled');
    $('.next')[$pages.index($active) == $pages.length - 2 ? 'addClass' : 'removeClass']('disabled');
    
  });
  
  $('.pagination li:eq(1)').trigger('click');

  $('#editBirdModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var birdId = button.data('bird-id');
    var editForm = $(this).find('form');
    var editAction = 'your_php_script.php?id=' + birdId;
    editForm.attr('action', editAction);
    editForm.find('input[name="_method"]').val('PUT'); // Add this line to set the method override
});

// 
// Filtro mygtukas Apacioje
// 
//  
$('.dropdown-item.continent').on('click', function (event) {
  event.preventDefault();
  var selectedContinent = $(this).text().trim();

  // Log the selected continent
  console.log('Selected Continent:', selectedContinent);

  // Make an AJAX request to get filtered bird cards
  $.ajax({
      url: birdsIndexUrl + '?continent=' + encodeURIComponent(selectedContinent),
      method: 'GET',
      success: function (data) {
          // Update the content with the new bird cards
          $('.container .row').html($(data).find('.container .row').html());

          // Update pagination links
          $('.pagination').html($(data).find('.pagination').html());

          // Reset pagination to the first page
          $('.pagination li:eq(1)').trigger('click');
      },
      error: function (error) {
          console.error('Error fetching bird cards:', error);
      }
  });
});
// Display continents in the modal
function displayContinentsInModal(continents) {
  var modalList = $('#allContinentsList');
  modalList.empty();

  $.each(continents, function (index, continent) {
      var listItem = $('<a href="#" class="list-group-item continent-dropdown-item"></a>').text(continent);
      modalList.append(listItem);
  });
}
// 
// disables pagination for filter
// 
$(document).ready(function () {
  // Initial hide/show based on selected continent
  filterBirdsByContinent();

  // Handle continent dropdown change
  $('.dropdown-item.continent').on('click', function (event) {
      event.preventDefault();
      var selectedContinent = $(this).text().trim();
      $('#selectedContinent').text(selectedContinent);
      filterBirdsByContinent(selectedContinent);
  });

  // Handle the "See More" link in the modal
  $('#allContinentsModal').on('shown.bs.modal', function () {
      fetchAllContinents(); // Fetch continents when the modal is shown
  });

  // Handle continent selection in the modal
  $('#allContinentsList').on('click', '.continent-dropdown-item', function (event) {
      event.preventDefault();
      var selectedContinent = $(this).text().trim();
      $('#selectedContinent').text(selectedContinent);
      filterBirdsByContinent(selectedContinent);
      $('#allContinentsModal').modal('hide'); // Close the modal after selecting a continent
  });
});


function filterBirdsByContinent(selectedContinent = null) {
  // Show or hide cards based on the selected continent
  $('.bird-card').each(function () {
      var cardContinent = $(this).data('continent');
      if (!selectedContinent || cardContinent === selectedContinent) {
          $(this).show();
      } else {
          $(this).hide();
      }
  });
}

function fetchAllContinents() {
  console.log('Fetching continents...');
  $.ajax({
      url: '/fetch-continents', // Replace with the actual endpoint for fetching all continents
      type: 'GET',
      success: function (continents) {
          console.log('Continents fetched:', continents);
          displayContinentsInModal(continents);
      },
      error: function (error) {
          console.error('Error fetching continents:', error);
      }
  });
}

function displayContinentsInModal(continents) {
  console.log('Displaying continents in modal:', continents);
  var continentsList = $('#allContinentsList');
  continentsList.empty();
  continents.forEach(function (continent) {
      var listItem = $('<a>', {
          href: '#',
          class: 'list-group-item list-group-item-action continent-dropdown-item',
          text: continent
      });
      continentsList.append(listItem);
  });
}