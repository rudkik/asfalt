function __init(){
    // выбираем новый файл
    $('.file-upload input[type="file"]:not([data-change-file-upload="1"])').change(function () {
        s = '';
        for(i = 0; i < this.files.length; i++){
            s = s + this.files[i].name + '; '
        }
        p = $(this).parent().attr('data-text', s);

    }).attr('data-change-file-upload', 1);

    /*
     * Поле сумма, разбиввание по разрядам 100 000
     * Параметры:
     * type="datetime" [date-type="date|time|datetime"
     * Подключение:
     <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.min.css"/>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/moment/moment.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.full.min.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
     */
    var fields = $('input[type="datetime"][date-type="date"], input[type="datetime"]:not([date-type])');
    fields.each(function (i) {
        var minDate = $(this).attr('date-min');
        $(this).datetimepicker({
            dayOfWeekStart: 1,
            lang: 'ru',
            format: 'd.m.Y',
            timepicker: false,
            scrollMonth:false,
            minDate: minDate
        }).keydown(function(event) {
            var code = event.keyCode;

            if (
                code == 46 || // delete
                code == 8 || // backspace
                code == 9 || // tab
                code == 27 || // ecs
                event.ctrlKey === true || // все что вместе с ctrl
                event.metaKey === true ||
                event.altKey === true || // все что вместе с alt
                (code >= 112 && code <= 123) || // F1 - F12
                (code >= 35 && code <= 39)) // end, home, стрелки
            {
                return;
            }

            if(this.selectionStart == this.selectionEnd ) {
                this.setSelectionRange(this.selectionStart, this.selectionStart + 1);
            }
        }).inputmask({
            mask: "99.99.9999"
        }).attr('autocomplete', 'off');
    });

    $('input[type="datetime"][date-type="datetime"]').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'ru',
        format: 'd.m.Y H:i',
        timepicker: true,
        scrollMonth:false,
    }).keydown(function(event) {
        var code = event.keyCode;

        if (
            code == 46 || // delete
            code == 8 || // backspace
            code == 9 || // tab
            code == 27 || // ecs
            event.ctrlKey === true || // все что вместе с ctrl
            event.metaKey === true ||
            event.altKey === true || // все что вместе с alt
            (code >= 112 && code <= 123) || // F1 - F12
            (code >= 35 && code <= 39)) // end, home, стрелки
        {
            return;

        }

        if(this.selectionStart == this.selectionEnd ) {
            this.setSelectionRange(this.selectionStart, this.selectionStart + 1);
        }
    }).inputmask({
        mask: "99.99.9999 99:99"
    }).attr('autocomplete', 'off');

    $('input[type="datetime"][date-type="time"]').datetimepicker({
        lang: 'ru',
        format: 'H:i',
        datepicker: false,
        scrollMonth:false,
    }).keydown(function(e) {
        if(this.selectionStart == this.selectionEnd ) {
            this.setSelectionRange(this.selectionStart, this.selectionStart + 1);
        }
    }).inputmask({
        mask: "99:99"
    }).attr('autocomplete', 'off');

    $('input[data-type="mobile"]').inputmask({
        mask: "+7(799) 999 99 99"
    }).attr('autocomplete', 'off');

    /**
     * Задаем фотмат поля
     * Параметры:
     * data-type="money"
     * data-fractional-length="2" - длина дробной части
     * Подключение:
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/format-money.js"></script>
     */
    $('input[data-type="money"]:not([data-type-money="1"])').attr('data-type-money', '1').priceFormat();

    /**
     * Делаем список с возможностью поиска
     * Параметры:
     * data-type="select2"
     * class="select2" - базовый
     * multiple="multiple" - множественный выбор
     * Подключение:
     <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
     */
    $('select[data-type="select2"]:not([data-select2="1"])').select2().attr('data-select2', 1);

    /**
     * Стилизация поля checkbox и radio
     * Параметры:
     * class="minimal" type="checkbox" | type="radio" (data-value="Значение отличное от 1")
     * Подключение:
     <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
     */
    $('input[type="radio"].minimal:not([data-checkbox-minimal="1"])').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    }).on('ifChecked', function (event) {
        $(this).trigger('change');
    }).on('ifUnchecked', function (event) {
        $(this).trigger('change');
    }).attr('data-checkbox-minimal', 1);

    $('input[type="checkbox"].minimal:not([data-checkbox-minimal="1"])').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    }).on('ifChecked', function (event) {
        var value = $(this).data('value');
        if(value === undefined){
            value = 1;
        }
        $(this).attr('value', value);
        $(this).attr('checked', '');

        var name = $(this).attr('name');
        if (name !== undefined){
            $(this).parent().parent().children('input[name="'+name+'"][type="text"]').attr('value', value);
        }
        $(this).trigger('change');
    }).on('ifUnchecked', function (event) {
        $(this).attr('value', '0');
        $(this).removeAttr('checked');
        var name = $(this).attr('name');
        if (name !== undefined){
            $(this).parent().parent().children('input[name="'+name+'"][type="text"]').attr('value', 0);
        }
        $(this).trigger('change');
    }).attr('data-checkbox-minimal', 1);
    // переводит чекбок в обычный инпут
    $('input[type="checkbox"].minimal:not([data-not-check="1"])').attr('type', 'check');

    // исчитаем сумму товаров при удалении записи
    $('[data-action="remove-tr"]:not([data-remove-tr="1"])').click(function (e) {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (i = 0; i < n; i++){
            parent = parent.parent();
        }

        parent.find('input[data-action="calc"], input[data-action="calc-piece"]').val(0).trigger('change');

        var n = Number($(this).data('row'));
        if(n > 0) {
            for (i = 1; i < n; i++) {
                parent.next().remove();
            }
        }

        parent.remove();

        return false;
    }).attr('data-remove-tr', 1);

    // в таблице сохранения активный / неактивный
    $('input[name="set-is-public-all"]').on('ifChecked', function (event) {
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            $(this).val(1);
            $(this).attr('checked', 'checked');
            $(this).parent().addClass('checked');

            $(this).trigger('ifChecked');
        });
    }).on('ifUnchecked', function (event) {
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            $(this).val(0);
            $(this).removeAttr('checked');
            $(this).parent().removeClass('checked');

            $(this).trigger('ifUnchecked');
        });
    });

    // в таблице сохранения активный / неактивный
    $('input[data-action="set-checkbox"]:not([data-set-is-public="1"]), input[name="set-is-public"]:not([data-set-is-public="1"])').on('ifChecked', function (event) {
        var isPublic = 1;
        var url = $(this).attr('href');

        var field = $(this).data('field');
        if(field == undefined || field == ''){
            field = 'is_public';
        }
        var data = {};
        data['json'] = 1;
        data[field] = isPublic;

        jQuery.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }).on('ifUnchecked', function (event) {
        var isPublic = 0;
        var url = $(this).attr('href');

        var field = $(this).data('field');
        if(field == undefined || field == ''){
            field = 'is_public';
        }
        var data = {};
        data['json'] = 1;
        data[field] = isPublic;

        jQuery.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }).attr('data-set-is-public', 1);



    $('[data-action="product"]:not([data-action-product="1"])').each(function () {
        var queryClient = '';
        var select = $(this);

        var parent = select.data('parent');
        if(parent == undefined || parent == ''){
            parent = select.parent();
        }else {
            parent = $(parent);
        }

        var basicUrl =  $(this).data('basic-url');

        select.select2({
            dropdownParent: parent,
            placeholder: 'Выберите значение',
            allowClear: true,
            language: 'ru',
            ajax: {
                url: function (params) {
                    queryClient = params.term;
                    return '/' + basicUrl + '/shopproduct/json?sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=article&is_public_ignore=1&name_article=' + params.term;
                },
                dataType: 'json',
                delay: 50,
                processResults: function (data, params) {
                    params.page = 1;
                    return {
                        results: data
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1,
            templateResult: function (repo, container) {
                if(repo.name == undefined){
                    return 'Данные не найдены';
                }

                var name = repo.article + ' ' +repo.name;

                var term = queryClient
                    .replace(/\\/g, '\\')
                    .replace(/\//g, '\\/')
                    .replace(/\[/g, '\\[')
                    .replace(/\]/g, '\\]')
                    .replace(/\(/g, '\\(')
                    .replace(/\)/g, '\\)')
                    .replace(/\{/g, '\\{')
                    .replace(/\}/g, '\\}')
                    .replace(/\?/g, '\\?')
                    .replace(/\+/g, '\\+')
                    .replace(/\*/g, '\\*')
                    .replace(/\|/g, '\\|')
                    .replace(/\./g, '\\.')
                    .replace(/\^/g, '\\^')
                    .replace(/\$/g, '\\$');
                name = name.replace(new RegExp(term, 'ig'), '<b>$&</b>');
                return name;
            },
            templateSelection: function (repo, container) {
                var name = repo.name || repo.text;
                return name;
            },
        }).change(function () {
            var basicURL = $(this).data('basic-url');

            var client = $(this).val();
        }).attr('data-action-shop_client', '1');

        // получение выделенного элемента
        var dataID = select.data('value');
        if(dataID > 0){
            jQuery.ajax({
                url: '/' + select.data('basic-url') + '/shopproduct/json?sort_by[name]=asc&is_public_ignore=1&limit=1&_fields[]=name&_fields[]=article&id=' + dataID,
                type: "POST",
                success: function (data) {
                    var data = jQuery.parseJSON($.trim(data));

                    $.each(data, function (index, value) {
                        var newOption = new Option(value.name, value.id, false, false);
                        select.append(newOption).val(dataID).trigger('change');
                    });
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }

        if(select.val() > 0){
            select.trigger('change');
        }
    });

    $('[data-action="price-edit"]:not([data-action-price="1"]), [data-action="quantity-edit"]:not([data-action-price="1"])').change(function (event) {
        var tr = $(this).closest('tr');

        tr.find('[data-id="amount"]').val(
            Number(tr.find('[data-action="price-edit"]').val())
            * Number(tr.find('[data-action="quantity-edit"]').val())
        );
    }).attr('data-action-price', 1);
}

function addElement(from, to, isLast, $isPrevLast){
    var index = $('#'+from).data('index') * 1 + 1;
    $('#'+from).data('index', index);

    var html = $('#'+from).html().replace('<!--', '').replace('-->', '').replace(/#index#/g, index);

    if(isLast){
        var total = $('#'+to).find('[data-id="table-total"]');
        if(total.length > 0){
            total.before(html);
        }else{
            $('#'+to).append(html);
        }
    }else{
        $('#'+to).prepend(html);
    }

    __init();
}
__init();