$(document).ready(function () {
    $('[data-action="direction"]').hover(function () {
        var parent = $(this).data('parent');
        parent = $(parent);

        $(this).parent().parent().find('.sector').removeClass('active');
        $(this).addClass('active');

        parent.children('div').removeClass('active');
        parent.children('div[data-id="'+$(this).data('id')+'"]').addClass('active');
    });
});