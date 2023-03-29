function __init(){
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