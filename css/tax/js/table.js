
var ctrlPressed = false;
var shiftPressed = false;

var clickButton = false;

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
    fields = $('input[type="datetime"][data-type="date"]:not([data-datetime="1"])');
    if (fields.length > 0) {
        fields.datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        }).inputmask({
            mask: "99.99.9999"
        }).attr('data-datetime', 1);
    }

    // считаем сумму строки
    $('td [data-action="tr-calc-amount"]').change(function () {
        var parent = $(this).parent().parent();

        var price = Number(parent.find('[data-id="price"]').val());
        var sum = Number(parent.find('[data-id="quantity"]').val()) * price;

        var nds = $(this).data('nds');
        if(nds !== undefined){
            nds = Number(nds);
            sum = sum / 100 * (100 + nds);
            parent.find('[data-id="price-nds"]').text(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(
                price / 100 * (100 + nds)
            ).replace(',', '.'));
        }

        var amount = parent.find('[data-id="amount"]');
        amount.text(
            Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(
                sum
            ).replace(',', '.')
        );
        amount.data('amount', sum);

        var total = 0;
        parent.parent().find('[data-id="amount"]').each(function (i) {
            total = total + Number($(this).data('amount'));
        });
        $(amount.data('total')).val(
            Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(
                total
            ).replace(',', '.')
        );

        return false;
    });

    // удаление записи в таблицы
    $('td [data-action="tr-delete"]').click(function () {
        var parent = $(this).parent().parent();
        parent.find('[data-id="quantity"]').val(0).trigger('change');
        parent.remove();

        return false;
    });

    fields = $('select.ks-select:not([data-select2="1"])');
    if (fields.length > 0) {
        fields.select2({dropdownParent: $(fields.data('parent'))});
        fields.attr('data-select2', 1);
    }

    field = $('.money-format:not([data-money-format="1"])');
    if (field.length > 0) {
        field.attr('data-money-format', 1);

        field.each(function () {
            $(this).number(true, $(this).data('decimals'), '.', ' ');
        });

    }

    // поиск товаров по названию
    field = $('.products.typeahead:not([data-typeahead="1"])');
    if (field.length > 0) {
        field.attr('data-typeahead', 1);

        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/tax/shopproduct/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name&_fields[]=unit_name&_fields[]=price&_fields[]=is_service',
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
                    '<div class="empty-message">Товар не найден</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{name}}</div>')
            }
        });
        field.on('keypress', function (e) {
            if (e.which == 13) {
                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
            }
        });
        field.on('typeahead:select', function(e, selected) {
            var parent = $(this).parents('tr');
            parent.find('[data-name="price"]').val(selected.price).trigger('change');
            parent.find('[data-name="is_service"]').prop('checked', selected.is_service == 1);
            parent.find('[data-name="unit"]').val(selected.unit_name);
        });
    }

    // поиск работников по ФИО
    field = $('.workers_name.typeahead:not([data-typeahead="1"])');
    if (field.length > 0) {
        field.attr('data-typeahead', 1);

        var workers = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/tax/shopworker/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name&_fields[]=iin&_fields[]=date_of_birth',
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
            source: workers,
            templates: {
                empty: [
                    '<div class="empty-message">Сотрудник не найден</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{name}}</div>')
            }
        });

        field.on('keypress', function (e) {
            if (e.which == 13) {
                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
            }
        });
        field.on('typeahead:select', function(e, selected) {
            var parent = $(this).parents('tr');
            parent.find('[data-name="iin"]').val(selected.iin);
            parent.find('[data-name="date_of_birth"]').val(selected.date_of_birth.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', ''));
        });
    }

    // поиск работников по ИИН
    field = $('.workers_iin.typeahead:not([data-typeahead="1"])');
    if (field.length > 0) {
        field.attr('data-typeahead', 1);

        var workers = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/tax/shopworker/json?iin=%QUERY&sort_by[iin]=asc&limit=25&_fields[]=iin&_fields[]=name&_fields[]=date_of_birth',
                wildcard: '%QUERY'
            }
        });
        field.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'best-pictures',
            display: 'iin',
            source: workers,
            templates: {
                empty: [
                    '<div class="empty-message">Сотрудник не найден</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{iin}}</div>')
            }
        });

        field.on('keypress', function (e) {
            if (e.which == 13) {
                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
            }
        });
        field.on('typeahead:select', function(e, selected) {
            var parent = $(this).parents('tr');
            parent.find('[data-name="name"]').val(selected.name);
            parent.find('[data-name="date_of_birth"]').val(selected.date_of_birth.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', ''));
        });
    }

    // поиск единицы измерения по названию
    field = $('.units.typeahead:not([data-typeahead="1"])');
    if (field.length > 0) {
        field.attr('data-typeahead', 1);

        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/tax/unit/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name',
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
                    '<div class="empty-message">Единица измерения не найдена</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{name}}</div>')
            }
        });
        field.on('keypress', function (e) {
            if (e.which == 13) {
                $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
            }
        });
    }

    // выбираем новый файл
    field = $('.file-upload input[type="file"]:not([data-file-upload="1"])');
    if (field.length > 0) {
        field.attr('data-file-upload', 1);
        field.change(function () {
            s = '';
            for(i = 0; i < this.files.length; i++){
                s = s + this.files[i].name + '; '
            }
            s = s.substr(0, s.length - 2);
            p = $(this).parent().attr('data-text', s);
        });
    }
}

function __initTable() {
    __initTr();

    fields = $('[data-action="close-add-panel"]:not([data-close-add-panel="1"])');
    if (fields.length > 0) {
        fields.attr('data-close-add-panel', 1);

        fields.click(function () {
            var tmp = $($(this).data('select'));
            tmp.val(0).trigger('change');
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



    fields = $('table[data-action="tax-table"]:not([data-tax-table="1"])');
    if (fields.length > 0) {
        fields.attr('data-tax-table', 1);

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
            $(id).bootstrapTable('refresh');
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

    fields = $('[data-action="table-record-refresh"]:not([data-table-record-refresh="1"])');
    if (fields.length > 0) {
        fields.attr('data-table-record-refresh', 1);

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
                        $(id).bootstrapTable('refresh');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });
        });
    }

    fields = $('[data-action="table-delete"]:not([data-table-delete="1"])');
    if (fields.length > 0) {
        fields.attr('data-table-delete', 1);

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

            var selects = table.bootstrapTable('getSelections');
            jQuery.each(selects, function (index, value) {
                jQuery.ajax({
                    url: url,
                    data: ({
                        'id': (value.id),
                    }),
                    type: "POST",
                    success: function (data) {
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

            $(modal).modal('hide');

            jQuery.ajax({
                url: url,
                data: ({}),
                type: "POST",
                success: function (data) {
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
function getIsInvoiceCommercialList(value, row) {
    if ((value !== null) && (value.length > 0)) {
        return 'да';
    }else{
        return 'нет';
    }
}
function getIsPaid(value, row) {
    if ((value == 1)) {
        return 'оплачен';
    }else{
        return 'не оплачен';
    }
}
function getIsDate(value, row) {
    if ((value !== undefined) && (value !== null) && (value !== '1970-01-01') && (value !== '1970-01-01 06:00:00')) {
        return value.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
    }else{
        return '';
    }
}
function getIsDateTime(value, row) {
    if ((value !== undefined) && (value !== null) && (value !== '1970-01-01') && (value !== '1970-01-01 06:00:00')) {
        return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
    }else{
        return '';
    }
}
function getIsDateMonth(value, row) {
    if ((value !== undefined) && (value !== null) && (value !== '1970-01-01') && (value !== '1970-01-01 06:00:00')) {

        var month = value.replace(/(\d+)-(\d+)-(\d+)/, '$2');
        switch (month) {
            case '1':
            case '01': month = 'январь'; break;
            case '2':
            case '02': month = 'февраль'; break;
            case '3':
            case '03': month = 'март'; break;
            case '4':
            case '04': month = 'апрель'; break;
            case '5':
            case '05': month = 'май'; break;
            case '6':
            case '06': month = 'июнь'; break;
            case '7':
            case '07': month = 'июль'; break;
            case '8':
            case '08': month = 'август'; break;
            case '9':
            case '09': month = 'сентябрь'; break;
            case '10': month = 'октябрь'; break;
            case '11': month = 'ноябрь'; break;
            case '12': month = 'декабрь'; break;
            default:
                month = '';
        }

        return month +' ' + value.replace(/(\d+)-(\d+)-(\d+)/, '$1').replace(' 00:00:00', '')+' г.';
    }else{
        return '';
    }
}
function getIsAmount(value, row) {
    if ((value !== undefined) && (value !== null)) {
        return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
    }else{
        return '';
    }
}