
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

