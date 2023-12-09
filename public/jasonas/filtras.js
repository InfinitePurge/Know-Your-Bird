$(document).ready(function () {
    // Attach a click event listener to the kilme dropdown items
    $('.DropDownText').on('click', function () {
        // Get the selected kilme value
        var selectedKilme = $(this).text();

        console.log("Selected Kilme:", selectedKilme);

        // Hide all bird cards
        $('.bird-card').hide();

        // Show only the cards with the selected kilme
        $('.bird-card[data-continent="' + selectedKilme + '"]').show();

        // Log the number of cards found
        var numCards = $('.bird-card[data-continent="' + selectedKilme + '"]').length;
        console.log("Number of cards with selected Kilme:", numCards);
    });
});





