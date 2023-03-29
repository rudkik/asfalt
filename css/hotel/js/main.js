$(document).ready(function() {
    function _initMain() {
        $('[data-action="tab-close"]').click(function () {
            var button = $(this).parent().children('[data-action="tab-open"]');
            var id = button.data('target');

            var isActive = button.hasClass('active');
            var parent = $(this).parent().parent().parent();

            $(this).parent().parent().remove();
            $(id).remove();

            if(isActive){
                parent.find('li:first [data-action="tab-open"]').click();
            }
            return false;
        });
        $('[data-action="tab-open"]').click(function () {
            $(this).parent().parent().parent().find('[data-action="tab-open"].active').removeClass('active');
            $(this).addClass('active');

            var curent = $($(this).data('target'));
            curent.parent().children('.active').removeClass('active');
            curent.addClass('active');

            $('body').data('table-select', $(this).data('target'));
            return false;
        });
    }

    _initMain();

    $('[data-action="add-modal"]').click(function () {
        var url = $(this).attr('href');
        var title = $(this).data('title');
        var id = $(this).data('id');

        if ($('#'+id).length == 0) {
            jQuery.ajax({
                url: url,
                data: ({
                    'is_main_not': (1),
                }),
                type: "POST",
                success: function (data) {
                    $('#tab-modals [data-action="tab-open"].active').removeClass('active');
                    html = '<li class="nav-item">\n' +
                        '<div class="btn-group dropup">\n' +
                        '<a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#' + id + '">'+title+'</a>\n' +
                        '<a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>\n' +
                        '</div>\n' +
                        '</li>';
                    $('#tab-modals').append(html);
                    _initMain();

                    $('#body-modals > div.active').removeClass('active');
                    html = '<div class="tab-pane active ks-column-section" id="' + id + '" role="tabpanel" aria-expanded="false">' + data + '</div>'
                    $('#body-modals').append(html);

                    $('body').data('table-select', '#'+id);
                    __initTable();
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }else{
            $('[data-target="#'+id+'"]').click();
        }

        return false;
    });

    $(document).bind('keydown', 'del', function (evt){
        var id = $('body').data('table-select');
        $(id+' [data-action="table-delete"]').click();
        return false;
    });
    $(document).bind('keydown', 'shift+a', function (evt){
        var id = $('body').data('table-select');
        $(id+' [data-action="table-edit"]').click();
        return false;
    });
    $(document).bind('keydown', 'shift+z', function (evt){
        var id = $('body').data('table-select');
        $(id+' [data-action="table-new"]').click();
        return false;
    });

    $(document).bind('keydown', 'down', function (evt){
        var id = $('body').data('table-select');
        return false;
    });
    $('body').data('table-select', $('a[data-action="tab-open"].active').data('target'));

    $.validate({
        modules : 'location, date, security, file',
        lang: 'ru',
        onModulesLoaded : function() {
        }
    });
});


function getIsBillFinish(value, row) {
    if (value == 1) {

        value = row['shop_bill_finish_date'];
        if ((value === undefined) || (value === null)) {
            value = row['finish_date'];
        }
        if ((value === undefined) || (value === null)) {
            return '';
        }else{
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }
    }else{
        return '';
    }
}