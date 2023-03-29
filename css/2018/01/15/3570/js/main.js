$('img[data-action="img-select"]').click(function () {
    $('#'+$(this).data('id')).attr('src', $(this).attr('href'));
});