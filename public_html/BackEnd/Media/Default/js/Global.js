$(document).ready(function() {

// Add padding to <main> to compensate for sticky header
var headerHeight = $('#header').outerHeight();
$('#main').css('margin-top', headerHeight);

});

$(window).resize(function() {
// Add padding to <main> to compensate for sticky header
var headerHeight = $('#header').outerHeight();
$('#main').css('margin-top', headerHeight);
});