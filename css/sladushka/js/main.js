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

    $.validate({
        modules : 'location, date, security, file',
        lang: 'ru',
        onModulesLoaded : function() {
        }
    });
});