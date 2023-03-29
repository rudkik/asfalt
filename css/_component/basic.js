/**
 * Округление числа
 * @param value
 * @param decimals
 * @returns {number}
 */
function roundNumber(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function __initBasic() {

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
     * Задаем фотмат поля
     * Параметры:
     * data-format="Формат"
     * Подключение:
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
     */
    $('input[data-format]:not([data-format-set="1"])').each(function () {
        $(this).inputmask({
            mask: $(this).data('format')
        });
    }).attr('data-format-set', '1');

    /**
    /**
     * Поле сумма, разбиввание по разрядам 100 000
     * Параметры:
     * type="datetime" [date-type="date|time|datetime"
     * Подключение:
     <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.min.css"/>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/moment/moment.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.full.min.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
     */
    $.datetimepicker.setLocale('ru');
    $('input[type="datetime"][date-type="date"], input[type="datetime"]:not([date-type])').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'ru',
        format: 'd.m.Y',
        timepicker: false,
        scrollMonth:false,
    }).inputmask({
        mask: "99.99.9999"
    }).attr('autocomplete', 'off');

    $('input[type="datetime"][date-type="datetime"]').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'ru',
        format: 'd.m.Y H:i',
        timepicker: true,
        scrollMonth:false,
    }).inputmask({
        mask: "99.99.9999 99:99"
    }).attr('autocomplete', 'off');

    $('input[type="datetime"][date-type="time"]').datetimepicker({
        lang: 'ru',
        format: 'H:i',
        datepicker: false,
        scrollMonth:false,
    }).inputmask({
        mask: "99:99"
    }).attr('autocomplete', 'off');

    /**
     * Поле сумма, разбиввание по разрядам 100 000
     * Параметры:
     * class="money-format"
     * Подключение:
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jquery-number/jquery.number.js"></script>
     */
    $('.money-format:not([data-money-format="1"])').each(function () {
        $(this).number(true, $(this).data('decimals'), '.', ' ');
    }).attr('data-money-format', 1);

    /**
     * Двойной клин на элементе таблицы, открывает ссылку
     * Параметры:
     * data-action="db-click-edit" - на tr
     * data-name="edit" - на ссылки
     */
    $('[data-action="db-click-edit"]:not([data-db-click-edit="1"])').dblclick(function () {
        var href = $(this).find('a[data-name="edit"]').attr('href');
        window.location.href = href;

    }).attr('data-db-click-edit', 1);

    /**
     * Удаление строчки таблицы
     * Параметры:
     * data-action="remove-tr" - на ссылки для удаления
     * data-parent-count="На какой количество родителей подняться" - на ссылки для удаления
     * data-row="Сколько строчек удалять" - на ссылки для удаления
     * data-id="index" - показывает нумерацию строчек
     */
    $('[data-action="remove-tr"]:not([data-remove-tr="1"])').click(function () {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (var i = 0; i < n; i++) {
            parent = parent.parent();
        }
        var root = parent.parent();

        var calcEl = parent.find('[data-action="tr-multiply"]');
        if (calcEl.length > 0) {
            var total = calcEl.first().data('total');
        }

        var n = Number($(this).data('row'));
        if (n > 0) {
            for (i = 1; i < n; i++) {
                parent.next().remove();
            }
        }
        parent.remove();

        // нумерация
        root.find('[data-id="index"]').each(function (i, el) {
            $(this).html(i + 1);
        });

        // проверяем были просчеты у элементов таблицы
        root = root.find('[data-action="tr-multiply"]');
        if (root.length > 0) {
            root.first().trigger('change');
        } else {
            $(total).attr('value', 0).text(0).val(0).trigger('change');
        }
        return false;
    }).attr('data-remove-tr', 1);

    /**
     * Делаем список с возможностью поиска для модального окна
     * Параметры:
     * data-type="select2"
     * data-parent="ссылка на модальное окно"
     * multiple="multiple" - множественный выбор
     * class="select2" - базовый
     * Подключение:
     <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
     */
    var fields = $('select[data-type="select2"][data-parent]:not([data-select2="1"])');
    fields.each(function () {
        $(this).select2({
            dropdownParent: $(fields.data('parent'))
        }).attr('data-select2', 1);
    });

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
     * Выделенние строки таблицы
     * Параметры:
     * data-action="table-select"]
     * Подключение:
     * Задать стиль выделение строки для класса current
     */
    $('table[data-action="table-select"] > tbody > tr +tr:not([data-select-tr="1"])').click(function (e) {
        if(e.shiftKey){
            var current = $(this).parent().find('tr.current');
            if(current.length == 0){
                $(this).addClass('selected');
            }else{
                $(this).parent().find('tr.selected').removeClass('selected');

                var currentIndex = current.index() - 1;
                var thisIndex = $(this).index() - 1;

                var items = $(this).parent().children('tr +tr');
                if(thisIndex >= currentIndex){
                    for(var i = currentIndex; i <= thisIndex; i++){
                        var item = items[i];
                        item.className = 'selected';
                    }
                }else{
                    for(var i = currentIndex; i >= thisIndex; i--){
                        item = items[i];
                        item.className = 'selected';
                    }
                }
            }
        }else {
            if (e.ctrlKey) {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    $(this).addClass('selected');
                }
            } else {

                $(this).parent().find('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        }

        $(this).parent().find('tr.current').removeClass('current');
        $(this).addClass('current');
    }).attr('data-select-tr', 1);

    /**
     * Стилизация поля выбора файла
     * Параметры:
     * type="file" class="file-upload"
     * Подключение:
     <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/css/style.css"  />
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.knob.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.ui.widget.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.iframe-transport.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.fileupload.js"></script>
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/script.js"></script>
     */
    $('.file-upload input[type="file"]:not([data-file-upload="1"])').change(function () {
        s = '';
        for(i = 0; i < this.files.length; i++){
            s = s + this.files[i].name + '; '
        }
        p = $(this).parent().attr('data-text', s);
    }).attr('data-file-upload', 1);

    /**
     * Стилизация поля checkbox и radio
     * Параметры:
     * class="minimal" type="checkbox" | type="radio" (data-value="Значение отличное от 1")
     * Подключение:
     <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
     <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
     */
    $('input[type="checkbox"].minimal, input[type="radio"].minimal:not([data-checkbox-minimal="1"])').iCheck({
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
    $('input[type="checkbox"].minimal').attr('type', 'check');

    /**
     * Меняем русские буквы на английские
     * Параметры:
     * data-type="rus-to-en"
     */
    $('input[data-type="rus-to-en"]:not([data-rus-to-en="1"])').keydown(function(e) {
        if ((e.ctrlKey == false) && (e.altKey == false)) {
            if (e.keyCode > 64 && e.keyCode < 91) {
                insertTextAtCursor(this, String.fromCharCode(e.keyCode));
                e.preventDefault();
                return false;
            }
        }
    }).attr('data-rus-to-en', 1);

    /**
     * Перемножить значение input b select[option[data-price=""]] в строки таблицы tr
     * Параметры:
     * data-action="tr-multiply-basic" data-total="ID суммы всех tr" data-parent-count="На какой количество родителей подняться" - для каждого элемента учавствующего в умножении
     * data-id="total" - элемента для вывода результата одной tr data-round="Не обязательное округление кратное числу (5)"
     * Подключение:
     */
    $('[data-action="tr-multiply-basic"]:not([data-tr-multiply="1"])').change(function () {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (var i = 0; i < n; i++){
            parent = parent.parent();
        }

        var round = $(this).data('round');

        var amount = 1;
        parent.find('[data-action="tr-multiply"]').each(function (i, el) {
            if (el.localName == 'select') {
                amount = amount * Number($(this).find('option[value="' + $(this).val() + '"]').data('price'));
            } else {
                if (el.localName == 'input') {
                    amount = amount * Number($(this).val());
                } else {
                    amount = amount * Number($(this).attr('value'));
                }
            }
        });
        if(round > 0){
            amount = (roundNumber(amount / round, 0)).toFixed() * round;
        }

        var amountStr = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.').replace('.00', '');
        var total = parent.find('[data-id="total"]');
        total.attr('value', amount).text(amountStr).val(amount).trigger('change');

        var amount = 0;
        parent.parent().find('[data-id="total"]').each(function () {
            var s = Number($(this).attr('value'));
            if(s > 0) {
                amount = amount + s;
            }
        });
        amountStr = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.').replace('.00', '');
        $($(this).data('total')).attr('value', amount).text(amountStr).val(amount).trigger('change');
    }).attr('data-tr-multiply', 1);


    /**
     * Увеличение значение на 1 или заданное значение
     * Параметры:
     * data-action="count-plus"
     * data-count="элемент для увеличения (data-id="")"
     * data-parent-count="На какой количество родителей подняться"
     * data-value="На какое количество увеличить, по умолчанию 1"
     * Подключение:
     */
    $('[data-action="count-plus"]:not([data-count-plus="1"])').click(function () {
        var n = Number($(this).data('parent-count'));
        var parent = $(this);
        for (i = 0; i < n; i++){
            parent = parent.parent();
        }

        var v = $(this).data('value');
        if(v === undefined){
            v = 1;
        }

        var count = parent.find('[data-id="'+$(this).data('count')+'"]');
        v = Number(count.val()) + Number(v);
        if(v < 0){
            v = 0;
        }
        count.val(v).trigger('change');
    }).attr('data-count-plus', 1);

    /**
     * Сохранение поля в базу данных
     * Параметры:
     * data-action="save-field"
     * href="ссылка для сохранения"
     * data-field="Поле которое нужно сохранить"
     * data-id="ID записи"
     * Подключение:
     */
    $('input[data-action="save-field"]:not([data-save-field="1"])').change(function (event) {
        var field = $(this).data('field');
        var url = $(this).attr('href');
        var id = Number($(this).data('id'));
        if(field != '' && url != '' && id > 0) {
            var value = $(this).val();

            var data = {};
            data['json'] = 1;
            data[field] = value;
            data['id'] = id;

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
        }
    }).attr('data-save-field', 1);
}

/**
 * Меняем русские буквы на английские
 * @param el
 * @param text
 * @param offset
 */
function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number"
        && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}

/**
 * Добавить элемент из <!-- Код элемента --!>
 * @param from - id откуда взять элемент
 * @param to - id откуда добавить элемент
 * @param isLast - в конец или начало
 *
 * data-id="index" - если нужна нумерация
 */
function addElement(from, to, isLast){
    var index = $('#'+from).data('index') * 1 + 1;
    $('#'+from).data('index', index);

    var html = $('#'+from).html().replace('<!--', '').replace('-->', '').replace('--!>', '').replace(/#index#/g, index);

    html = $(html);

    if(isLast){
        $('#'+to).append(html);
    }else{
        $('#'+to).prepend(html);
    }

    // нумерация
    $('#'+to).find('[data-id="index"]').each(function (i, el) {
        $(this).html(i + 1);
    });


    __initBasic();
    _initMain();

    return html;
}

