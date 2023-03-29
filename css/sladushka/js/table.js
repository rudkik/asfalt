
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

    fields = $('select.ks-select:not([data-select2="1"])');
    if (fields.length > 0) {
        fields.select2({dropdownParent: $(fields.data('parent'))});
        fields.attr('data-select2', 1);
    }

    field = $('.money-format:not([data-money-format="1"])');
    if (field.length > 0) {
        field.attr('data-money-format', 1);
        field.number(true, 0, '.', ' ');
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



    fields = $('table[data-action="sladushka-table"]:not([data-sladushka-table="1"])');
    if (fields.length > 0) {
        fields.attr('data-sladushka-table', 1);

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