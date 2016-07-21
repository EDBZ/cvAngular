$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox({
    });
});

// $('.drop-box').click(function(){
//   alert('test');
// });
