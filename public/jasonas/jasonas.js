
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

document.addEventListener("DOMContentLoaded", function () {
  var filterButton = document.getElementById("filterButton");
  var filterContainer = document.getElementById("filterContainer");

  filterButton.addEventListener("click", function () {
      filterContainer.style.display = (filterContainer.style.display === "block") ? "none" : "block";
  });

  window.addEventListener("click", function (event) {
      if (event.target !== filterButton && !filterContainer.contains(event.target)) {
          filterContainer.style.display = "none";
      }
  });
});

// 
//  filtro funkcija mygtuko
//  
document.addEventListener("DOMContentLoaded", function() {
  // Initialize Bootstrap dropdown
  var dropdown = new bootstrap.Dropdown(document.getElementById("filterContainer"));

  // Get the necessary elements
  const filterTag = document.getElementById("filterTag");
  const continentDropdown = document.getElementById("continentDropdown");

  // Add click event listener to the continent dropdown items
  continentDropdown.addEventListener("click", function(event) {
      if (event.target.classList.contains("dropdown-item")) {
          // Update the text of the filterTag button with the selected continent
          filterTag.textContent = event.target.textContent;
          // Close the dropdown after selecting a continent
          dropdown.hide();
      }
  });
});
