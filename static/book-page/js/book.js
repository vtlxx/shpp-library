var pathname = $(location).attr('pathname');
var bookIdPosition = pathname.lastIndexOf('/') + 1;
var bookId = pathname.substr(bookIdPosition);

$('.btnBookID').click(function(event) {
    console.log('into');
    $('#order-book-modal').modal('show');
    $.ajax('http://library.local/books/?click=' + bookId);
});
