
var ctrlPressed = false;
var shiftPressed = false;

function addTr(from, to) {
    var form = $(from);
    var index = form.data('index');
    form.data('index', Number(index) + 1);

    var tmp = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));

    $(to).append(tmp);
    __initTr();
}

$(document).ready(function() {
    $(window).keydown(function (evt) {
        if (evt.which == 17) { // ctrl
            ctrlPressed = true;
        } else {
            if (evt.which == 16) { // ctrl
                shiftPressed = true;
            }
        }
    }).keyup(function (evt) {
        if (evt.which == 17) {
            ctrlPressed = false;
        } else {
            if (evt.which == 16) { // ctrl
                shiftPressed = false;
            }
        }
    });
    __initTable();
});
function __initTr() {
    fields = $('input[type="datetime"][data-type="datetime"]:not([data-datetime="1"])');
    if (fields.length > 0) {
        fields.datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y H:i',
            timepicker:true,
        });
        fields.attr('data-datetime', 1);
    }

    fields = $('input[type="phone"]:not([data-inputmask="1"])');
    if (fields.length > 0) {
        fields.inputmask({
            mask: "+9-999-999-99-99"
        });
        fields.attr('data-inputmask', 1);
    }

    fields = $('select.ks-select:not([data-select2="1"])');
    if (fields.length > 0) {
        fields.select2({dropdownParent: $(fields.data('parent'))});
        fields.attr('data-select2', 1);
    }

    // удаление записи в таблицы
    $('td [data-action="tr-delete"]').click(function () {
        var parent = $(this).parent().parent();
        parent.find('[data-id="quantity"]').val(0).trigger('change');
        parent.remove();

        return false;
    });

    field = $('.money-format:not([data-money-format="1"])');
    if (field.length > 0) {
        field.attr('data-money-format', 1);

        field.each(function () {
            $(this).number(true, $(this).data('decimals'), '.', ' ');
        });
    }
}
function __initTable() {
    __initTr();

    field = $('.clients.typeahead:not([data-typeahead="1"])');
    if (field.length > 0) {
        field.attr('data-typeahead', 1);

        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '/ads/shopclient/json?limit=15',
            remote: {
                url: '/ads/shopclient/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name&_fields[]=delivery_amount&_fields[]=id',
                wildcard: '%QUERY'
            }
        });
        field.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'best-pictures',
            display: 'name',
            source: products,
            templates: {
                empty: [
                    '<div class="empty-message">Клиент не найден</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{name}} ({{id}})</div>')
            }
        });
        field.on('keypress', function (e) {
            if (e.which == 13) {
                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
            }
        });
        field.on('typeahead:select', function(e, selected) {
            var client = $($(this).data('client'));
            client.data('delivery-amount', selected.delivery_amount).val(selected.id).attr('value', selected.id).trigger('change');
        });
    }

    field = $('.parcels.typeahead:not([data-typeahead="1"])');
    if (field.length > 0) {
        field.attr('data-typeahead', 1);

        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '/ads/shopparcel/json?limit=15',
            remote: {
                url: '/ads/shopparcel/json?id=%QUERY&sort_by[name]=asc&limit=25&_fields[]=text&_fields[]=id&_fields[]=shop_client_id&_fields[]=shop_client_name',
                wildcard: '%QUERY'
            }
        });
        field.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'best-pictures',
            display: 'id',
            source: products,
            templates: {
                empty: [
                    '<div class="empty-message">Посылка не найдена</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{id}} ({{text}})</div>')
            }
        });
        field.on('keypress', function (e) {
            if (e.which == 13) {
                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
            }
        });
        field.on('typeahead:select', function(e, selected) {
            var client = $($(this).data('client-name'));
            client.val(selected.shop_client_name);

            var client = $($(this).data('client-id'));
            client.val(selected.shop_client_id).attr('value', selected.shop_client_id);
        });
    }

    fields = $('select.ks-select:not([data-select2="1"])');
    if (fields.length > 0) {
        fields.select2({dropdownParent: $(fields.data('parent'))});
        fields.attr('data-select2', 1);
    }

    fields = $('[data-action="close-add-panel"]:not([data-close-add-panel="1"])');
    if (fields.length > 0) {
        fields.attr('data-close-add-panel', 1);

        fields.click(function () {
            var tmp = $($(this).data('select'));
            tmp.val(0).trigger('change');
        });
    }

    fields = $('[data-action="find"]:not([data-action-find="1"])');
    if (fields.length > 0) {
        fields.attr('data-action-find', 1);

        fields.click(function (e) {
            e.preventDefault();

            var find = $($(this).data('find'));
            var table = $($(this).data('table'));

            var url = table.data('basic-url');
            if (url === undefined){
                url = table.data('url');
            }
            table.data('basic-url', url);

            var params = find.serialize();
            url = url + '&' + params;

            table.data('url', url);
            table.bootstrapTable('refresh', {
                url: url
            });
        });
    }

    fields = $('[data-action="add-new-panel"]:not([data-add-new-panel="1"])');
    if (fields.length > 0) {
        fields.attr('data-add-new-panel', 1);

        fields.click(function () {
            var tmp = $($(this).data('select'));
            tmp.val(-1).trigger('change');
        });
    }

    fields = $('table[data-action="ads-table"]:not([data-ads-table="1"])');
    if (fields.length > 0) {
        fields.attr('data-ads-table', 1);

        fields.bootstrapTable({
            icons: {
                refresh: 'fa fa-refresh icon-refresh',
                toggle: 'fa fa-list-alt icon-list-alt',
                columns: 'fa fa-th icon-th',
                export: 'fa fa-download icon-share'
            }
        });

        fields.on('dbl-click-row.bs.table', function (e, row, $element, field) {
            $(this).bootstrapTable('uncheckAll');
            $(this).bootstrapTable('check', $element.data('index'));
            $($(this).data('dlb-click-button')).click();
        });

        fields.on('click-row.bs.table', function (e, row, $element, field) {
            var last = $element.data('index');
            if ((!ctrlPressed) && (!shiftPressed)) {
                var result = $element.hasClass('selected');

                $(this).bootstrapTable('uncheckAll');
                $(this).data('last', last);

                if (result) {
                    $(this).bootstrapTable('check', last);
                }
            } else {
                if (shiftPressed) {
                    $(this).bootstrapTable('uncheckAll');

                    var first = $(this).data('last');
                    if (last > first) {
                        for (var i = first; i < last; i++) {
                            $(this).bootstrapTable('check', i);
                        }
                    } else {
                        for (var i = last + 1; i <= first; i++) {
                            $(this).bootstrapTable('check', i);
                        }
                    }
                } else {
                    $(this).data('last', last);
                }
            }
        });
    }

    fields = $('[data-action="table-refresh"]:not([data-table-refresh="1"])');
    if (fields.length > 0) {
        fields.attr('data-table-refresh', 1);

        fields.click(function () {
            var id = $(this).data('table');
            $(id).bootstrapTable('refresh', {
                url: $(id).data('url')
            });
        });
    }

    fields = $('[data-action="table-download"]:not([data-table-download="1"])');
    if (fields.length > 0) {
        fields.attr('data-table-download', 1);

        fields.click(function () {
            var button = $(this);
            var id = button.data('table');
            var url = button.data('url');
            var table = $(id);

            var selects = table.bootstrapTable('getSelections');
            jQuery.each(selects, function (index, value) {
                button.attr('href', url+'?id='+value.id);
                return false;
            });
        });
    }

    fields = $('[data-action="table-delete"]:not([data-table-delete="1"])');
    if (fields.length > 0) {
        fields.attr('data-table-delete', 1);
        /*fields.confirm({
            title:"Удаление",
            text:"Удалить запись?",
            confirmButton: "Да",
            cancelButton: "Нет"
        });*/

        fields.click(function () {
            var id = $(this).data('table');
            var url = $(this).data('url');
            var table = $(id);

            var selects = table.bootstrapTable('getSelections');
            jQuery.each(selects, function (index, value) {
                jQuery.ajax({
                    url: url,
                    data: ({
                        'id': (value.id),
                    }),
                    type: "POST",
                    success: function (data) {

                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });

            var ids = $.map(table.bootstrapTable('getSelections'), function (row) {
                return row.id;
            });
            table.bootstrapTable('remove', {
                field: 'id',
                values: ids
            });
        });
    }

    fields = $('[data-action="table-edit"]:not([data-table-edit="1"])');
    if (fields.length > 0) {
        fields.attr('data-table-edit', 1);

        fields.click(function () {
            var id = $(this).data('table');
            var url = $(this).data('url');
            var modal = $(this).data('modal');
            var table = $(id);
            var child = $(this).data('child');

            var selects = table.bootstrapTable('getSelections');
            jQuery.each(selects, function (index, value) {
                jQuery.ajax({
                    url: url,
                    data: ({
                        'id': (value.id),
                    }),
                    type: "POST",
                    success: function (data) {
                        if (child != undefined) {
                            $(child).remove();
                        }

                        $(modal).remove();
                        $('body').append(data);
                        $(modal).modal('show');

                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
                return false;
            });
            return false;
        });
    }

    fields = $('[data-action="table-new"]:not([data-table-new="1"])');
    if (fields.length > 0) {
        fields.attr('data-table-new', 1);

        fields.click(function () {
            var id = $(this).data('table');
            var url = $(this).data('url');
            var modal = $(this).data('modal');
            var table = $(id);
            var child = $(this).data('child');

            jQuery.ajax({
                url: url,
                data: ({}),
                type: "POST",
                success: function (data) {
                    if (child != undefined) {
                        $(child).remove();
                    }

                    $(modal).remove();
                    $('body').append(data);
                    $(modal).modal('show');

                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
    }
}