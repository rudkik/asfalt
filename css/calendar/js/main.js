__init();

$(document).ready(function () {
    // двойной клин на элементе таблицы
    $('[data-action="db-click-edit"]:not([data-db-click-edit="1"])').dblclick(function () {
        var href = $(this).find('a[data-name="edit"]').attr('href');
        window.location.href = href;

    }).attr('data-db-click-edit', 1);

    // удаление записи в таблицы
    $('table td li.tr-remove a:not([href=""]):not([href="#"]):not([data-tr-remove="1"])').click(function () {
        var url = $(this).attr('href');

        if(url != '') {
            var s = $(this).parent().parent();
            jQuery.ajax({
                url: url,
                data: ({
                    is_main: (1),
                    json: (1),
                }),
                type: "POST",
                success: function (data) {
                    s.removeClass('delete');
                    s.addClass('un-delete');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
            return false;
        }
    }).attr('data-tr-remove', '1');

    // восстановление записи в таблицы
    $('table td li.tr-un-remove a').click(function () {
        url = $(this).attr('href');

        var s = $(this).parent().parent();
        jQuery.ajax({
            url: url,
            data: ({
                is_main: (1),
                is_undel: (1),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
                s.removeClass('un-delete');
                s.addClass('delete');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
        return false;
    });

    var typeahead = $('input[data-action="find-typeahead"]:not([data-typeahead="1"])');
    typeahead.each(function () {
        var url = $(this).data('url');
        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: url,
                wildcard: '%QUERY'
            }
        });

        $(this).typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            name: 'best-pictures',
            display: 'name',
            source: bestPictures,
            templates: {
                empty: [
                    '<div class="empty-message">Запись не найдена</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{name}}</div>')
            }
        }).on('keypress', function(e) {
            if(e.which == 13) {
                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
            }
        }).on('change', function() {
            $(this).parent().removeClass('has-error');
        }).on('typeahead:select', function(e, selected) {
            $(this).parent().removeClass('has-error');
        });

        $(this).attr('data-typeahead', 1);
    });
});
function __init(){
    __initBasic();
}
function _initMain() {
    __init();
}