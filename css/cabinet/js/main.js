// инициализация Select2
function __initSelect2(elements){
    elements.each(function (i) {
        var current = $(this);

        var url = current.data('url');
        if((url === undefined) || (url === '')){
            current.select2();
        }else{
            current.select2({
                ajax: {
                    url: url,
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            name: params.term,
                        };
                        var select = current;

                        var type = select.data('type');
                        if(type > 0){
                            query['type'] = type;
                        }

                        // добавляем введенное изменение
                        var isAdd = select.data('is-add');
                        if(isAdd !== undefined){
                            query['is_add'] = isAdd;
                        }

                        var branch = select.data('shop');
                        if(branch > 0){
                            query['shop_branch_id'] = branch;
                        }

                        // Query parameters will be ?name=[term]&type=[type]&is_add=[isAdd]&shop_branch_id=[branch]
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
        }
    });
}

// повторная инициализация
function __init(){
    // копирование данных на сервер
    $('[data-action="copy-server"]:not([data-copy-server="1"])').click(function () {
        var id = $(this).data('parent');

        var data = {};
        data['data'] = $(id).find('select, textarea, input').serialize();
        data['key'] = $(this).data('name');
        data['data_language_id'] = $(this).data('language');

        $.ajax({
            type: 'POST',
            url: '/cabinet/buffer/set',
            data: data,
            success: function(data) {

            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    }).attr('data-copy-server', '1');

    // вставить данные с сервера
    $('[data-action="insert-server"]:not([data-insert-server="1"])').click(function () {
        var id = $(this).data('parent');
        var name = $(this).data('name');
        var isReplace = $(this).data('replace') == 1;

        var data = {};
        data['key'] = name;
        data['data_language_id'] = $(this).data('language');

        $.ajax({
            type: 'POST',
            url: '/cabinet/buffer/get',
            data: data,
            success: function(data) {
                name = name.replace('options.', '');
                if(isReplace){
                    $('#body_panel-'+name).empty();
                }

                var obj = jQuery.parseJSON($.trim(data));
                obj = obj.options[name];
                $.each(obj, function (number, value) {
                    var tr = actionAddTR('body_panel-' + name, 'tr_panel-' + name, 'div-not-options-options');

                    $.each(value, function (k, v) {
                        tr.find('[data-id="' + k + '"]').val(v).trigger('change');
                    });
                });
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    }).attr('data-insert-server', '1');

    $('[data-action="find-city"]:not([data-find-city="1"])').change(function () {
        var city = $(this).data('city');

        $.ajax({
            type: 'POST',
            url: '/cabinet/city/select_options',
            data: ({
                'land_id': $(this).val()
            }),
            success: function(data) {
                $(city).select2('destroy').empty().html(data).select2().val(-1);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
        return false;
    }).attr('data-find-city', '1');


    $('[data-action="register-sentence"]').click(function () {
        var id = $(this).data('id');

        var s = $(id).val();
        s = s.charAt(0).toUpperCase() + s.substr(1).toLowerCase();
        $(id).val(s);

        return false;
    });

    __initSelect2($(".select2"))

    // удаление записи в таблицы
    $('.table-db td li.tr-remove a[delete="tr"]').click(function () {
        $(this).parent().parent().parent().parent().remove();

        return false;
    });

    // выбор страны
    $('select[type="attribute_catalog_ids"]').change(function () {
        input = $(this).parent().parent().find('input[type="attribute_names"]');
        input.attr('list', 'shop_table_filters-' + $(this).val());
    });

    $('button[data-widget="remove"]').click(function () {
        $(this).parent().parent().parent().remove();

        return false;
    });

    $('a[data-action="tr-delete"]').click(function () {
        $(this).parent().parent().parent().parent().remove();

        return false;
    });

    // изменение название объекта для массивого добавления
    $('input[data-name="horde-name"]').keyup(function () {
        $(this).parent().parent().parent().parent().parent().find('[data-name="horde-title"]').text($(this).val());
    });
    $('input[data-name="horde-name"]').change(function () {
        $(this).parent().parent().parent().parent().parent().find('[data-name="horde-title"]').text($(this).val());
    });

    // сохранение одной записи для массивого добавления
    $('button[data-name="horde-save"]').click(function () {
        var tmp = $(this).parent().parent().parent();
        var msg = tmp.find('[name]').serializeArray();
        var href = $(this).attr('href');
        var index = $(this).data('index');
        $.ajax({
            type: 'POST',
            url: href,
            data: msg,
            success: function(data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (obj[index+'_'].error) {

                }else{
                    idElement = tmp.find('input[data-name="horde-id"]');
                    id = obj[index+'_']['values']['id'];
                    idElement.val(id);
                    idElement.attr('value', id);

                    files = obj[index+'_']['values']['files'];

                    urls = tmp.find('div[name="index"] input[data-id="file-url"]');
                    urls.each(function(index){
                        $(this).attr('value', files[index]['file']);
                    });

                    ids = tmp.find('div[name="index"] input[data-id="file-id"]');
                    ids.each(function(index){
                        $(this).attr('value', files[index]['id']);
                    });


                    $.each(files, function(index, value){
                        $('div[name="index"] input[data-id="file-id"]:nth-child('+index+')').attr('value', value['id']);
                        urls[index].attr('value', value['file']);
                    });
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });

    // добавления записи при массовом добавлении
    $('[data-name="horde-insert"]').click(function () {
        $('#new-horde-priview').html($('#new-horde').html().replace('<!--', '').replace('-->', ''));


        $('#list-horde').append($('#new-horde-priview').text());
        $('#new-horde-priview').html('');
    });


    $('td a[buttom-tr="save"]').click(function () {
        url = $(this).attr('href');
        id = $(this).attr('data-id');

        var datas = {};

        var s = $(this);
        var arr = $(this).parent().parent().find('input[name]');
        arr.each(function (i) {
            datas[jQuery(this).attr('name')] = jQuery(this).val();
        });

        var arr = $(this).parent().parent().find('textarea[name]');
        arr.each(function (i) {
            tmp = jQuery(this).attr('name');
            datas[tmp] = CKEDITOR.instances[tmp].getData();
        });

        datas['id'] = id;
        jQuery.ajax({
            url: url,
            data: (datas),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (!obj.error) {
                    s.attr('data-id', obj.values.id);
                    s.attr('class', 'btn btn-default btn-sm checkbox-toggle');
                    s.parent().find('a[buttom-tr="del"]').attr('data-id', obj.values.id);
                }
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });

        return false;
    });

    $('td input[data-action="input-tr-edit"]').change(function () {
        $(this).parent().parent().find('td a[buttom-tr="save"]').attr('class', 'btn btn-primary btn-sm checkbox-toggle');

        return false;
    });
    $('td input[data-action="input-tr-edit"]').keyup(function () {
        $(this).parent().parent().find('td a[buttom-tr="save"]').attr('class', 'btn btn-primary btn-sm checkbox-toggle');

        return false;
    });
}

function actionAddTRRedirect(bodyPanelID, trPanelID, isFirst) {
    var data = $('#' + bodyPanelID).data('index') + 1;
    $('#' + bodyPanelID).data('index', data);

    var tr = $.trim(
        $('#' + trPanelID).html()
            .replace('<!--', '')
            .replace('-->', '')
            .replace(/#index#/g, data)
    );

    if(isFirst){
        $('#' + bodyPanelID).prepend(tr);
    }else {
        $('#' + bodyPanelID).append(tr);
    }
    __init();

    return;
}

$(document).ready(function () {
    __init();

    // загрузка фотографии через массовое редактирование
    $('#modal-image form').on('submit', function(e){
        e.preventDefault();
        var $that = $(this),
            formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)

        id = $('#modal-image input[name="id"]').val();
        url = $(this).attr('action');
        jQuery.ajax({
            url: url,
            data: formData,
            type: "POST",
            contentType: false, // важно - убираем форматирование данных по умолчанию
            processData: false, // важно - убираем преобразование строк по умолчанию
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (!obj.error) {
                    $('#modal-img').attr('src', obj.file_name);
                    $('img[data-id="'+id+'"]').attr('src', obj.file_name);
                }
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    });

    // файл большого размера
    $('img[data-action="modal-image"]').click(function () {
        src = $(this).attr('src');
        var arr = src.split('/');
        file = arr[arr.length-1];
        var arr = file.split('.');
        file1 = arr[0];
        arr2 = file1.split('-');
        file2 = arr2[0] + '-950x700.' + arr[1];
        src = src.replace(file, file2);

        tmp = $('#modal-image input[name="file"]');
        tmp.attr('value', '');
        tmp.val('');
        tmp = tmp.parent();
        tmp.attr('data-text', tmp.attr('placeholder'))

        tmp = $('#modal-image input[name="file_url"]');
        tmp.attr('value', '');
        tmp.val('');

        $('#modal-image input[name="id"]').attr('value', $(this).data('id'));
        $('#modal-image form').attr('action', $(this).data('href'));
        $('#modal-img').attr('src', src);
        $('#modal-image').modal("show");
    });

    // выбираем новый файл
    $('.file-upload input[type="file"]').change(function () {
        s = '';
        for(i = 0; i < this.files.length; i++){
            s = s + this.files[i].name + '; '
        }
       // s = this.files[0].name;
        p = $(this).parent().attr('data-text', s);

    });

    // копируем данные select
    $('[data-action="copy-select"]').click(function () {
        $('body').data('copy', $(this).parent().parent().children('select').val());

        return false;
    });

    // втавляем данные select
    $('[data-action="insert-select"]').click(function () {
        n =  $('body').data('copy') * 1;
        if(n > 0) {
            $(this).parent().parent().children('select').val(n).trigger("change");
        }

        return false;
    });


    // поиск по статусам записей
    $('#tab-status > li:not(.header) > a').click(function () {
        var tmp = $('#input-status');
        tmp.attr('name', $(this).attr('data-id'));

        var value = $(this).attr('data-value') * 1;
        if(value > 0){
            tmp.attr('value', value);
            tmp.val(value);
        }

        $('#form-filter').attr('action', $(this).attr('href'));
        $('#search-button').click();

        return false;
    });

    // удаление записи в таблицы
    $('table td li.tr-remove a').click(function () {
        var url = $(this).attr('href');

        if(url == '') {
            $(this).parents('tr').remove();
        }else{
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
        }
        return false;
    });

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

    $('input[data-action="set-boolean"]').on('ifChecked', function (event) {
        $(this).parent().parent().parent().parent().parent().parent().find('input[data-action="boolean"]').each(function (i) {
            $(this).val(1);
            $(this).attr('checked', 'checked');
            $(this).parent().addClass('checked');
        });
    }).on('ifUnchecked', function (event) {
        $(this).parent().parent().parent().parent().parent().parent().find('input[data-action="boolean"]').each(function (i) {
            $(this).val(0);
            $(this).removeAttr('checked');
            $(this).parent().removeClass('checked');
        });
    });

    // в таблице сохранения активный / неактивный
    $('input[name="set-is-public-all"]').on('ifChecked', function (event) {
        isPublic = 1;
        url = $(this).attr('href');

        arr = {};
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            id = $(this).data('id');
            arr[id] = {'is_public':  isPublic, 'id': id};

            $(this).val(1);
            $(this).attr('checked', 'checked');
            $(this).parent().addClass('checked');
        });
        arr = {'shop_goods': arr, 'json': 1};

        jQuery.ajax({
            url: url,
            data: (arr),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    }).on('ifUnchecked', function (event) {
        isPublic = 0;
        url = $(this).attr('href');

        arr = {};
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="set-is-public"]').each(function (i) {
            id = $(this).data('id');
            arr[id] = {'is_public':  isPublic, 'id': id};

            $(this).val(0);
            $(this).removeAttr('checked');
            $(this).parent().removeClass('checked');
        });
        arr = {'shop_goods': arr, 'json': 1};

        jQuery.ajax({
            url: url,
            data: (arr),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    });

    // в таблице сохранения активный / неактивный
    $('input[name="set-is-public"]').on('ifChecked', function (event) {
        isPublic = 1;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_public: (isPublic),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    }).on('ifUnchecked', function (event) {
        isPublic = 0;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_public: (isPublic),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    });

    // меняем value в зависимости от нажатия
    $('input[type="checkbox"], input[type="radio"]').on('ifChecked', function (event) {
        $(this).attr('value', '1');
        $(this).attr('checked', '');
    }).on('ifUnchecked', function (event) {
        $(this).attr('value', '0');
        $(this).removeAttr('checked');
    });

    // переключение вкладок в акциях и скидках
    $('#promo-list > li > a').click(function () {
        tmp = $('#promo-type');
        id = $(this).attr('data-id');

        tmp.attr('value', id);
        tmp.val(id);

        return true;
    });

    // переключение вкладок подарков в акциях
    $('#gift-list > li > a').click(function () {
        tmp = $('#gift-type');
        id = $(this).attr('data-id');

        tmp.attr('value', id);
        tmp.val(id);

        return true;
    });

    // поиски товаров в акциях и скидках
    $('#find-goods-id button[type="submit"]').click(function () {
        actionFindGoods('find-goods-id', 'result-goods', 0, '/cabinet/shopgood/findpromo');

        return false;
    });

    // поиски статей подобные
    $('#find-news-similar-id button[type="submit"]').click(function () {
        actionFindGoods('find-news-similar-id', 'result-news', 0, '/cabinet/shopnew/findsimilar');

        return false;
    });

    // поиски товаров подобные
    $('#find-goods-similar-id button[type="submit"]').click(function () {
        actionFindGoods('find-goods-similar-id', 'result-goods-similar', 0, '/cabinet/shopgood/findsimilar');

        return false;
    });

    // поиски товаров подарков в акциях
    $('#find-goods-gift-id button[type="submit"]').click(function () {
        actionFindGoods('find-goods-gift-id', 'result-goods-gift', 0, '/cabinet/shopgood/findpromogift');

        return false;
    });

    // поиски товаров связанных
    $('#find-goods-group-id button[type="submit"]').click(function () {
        actionFindGoods('find-goods-group-id', 'result-goods', 0, '/cabinet/shopgood/findgroup');

        return false;
    });

    // выбор страны
    $('select[name="land_id"]').change(function () {
        landID = $(this).val() * 1;
        s = $('#city_id');
        $('#city_id').attr('disabled');
        jQuery.ajax({
            url: '/cabinet/city/select',
            data: ({
                land_id: (landID),
            }),
            type: "POST",
            success: function (data) {
                if(data != '') {
                    s.html('<select name="city_id" class="form-control select2" style="width: 100%;">' + data + '</select>');
                    __initSelect2($('select[name="city_id"]'));
                }
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    });

    // при нажатии на группу меняем зависимые элементы
    $('input[data-id="group"]').on('ifUnchecked', function (event) {
        $(this).parent().parent().parent().parent().find('ins[class="iCheck-helper"]').each(function (i) {
            if($(this).parent().find('input').attr('value') == 1) {
                $(this).click();
            }
        });
    });

    // выделенные строки таблицы
    $('table.table-db > tbody > tr +tr').click(function (e) {
        if(e.shiftKey){
            current = $(this).parent().find('tr.current');
            if(current.length == 0){
                $(this).addClass('selected');
            }else{
                $(this).parent().find('tr.selected').removeClass('selected');

                currentIndex = current.index() - 1;
                thisIndex = $(this).index() - 1;

                var items = $(this).parent().children('tr +tr');
                if(thisIndex >= currentIndex){
                    for(var i = currentIndex; i <= thisIndex; i++){
                        item = items[i];
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
    });

    // сохранение выделенных записей таблицы
    $('a[data-id="save-file-select"]').click(function () {
        url = $(this).attr('href');

        $('table.table-db > tbody > tr.selected > td[data-id="id"]').each(function(i){
            url = url + '&ids[]=' + $(this).text() * 1;
        });

        window.location.href = url;
        return false;
    });

    // сортировка записей
    $("#sort-record").sortable({
        zIndex: 999999,
        helper: 'clone',
        opacity: 0.55,
        update: function() {
            $('#sort-record > tr').each(function(index) {
                indexDiv = $(this).find('input[data-id="order"]');
                indexDiv.val(index);
                indexDiv.attr('value', index);
            });
        }
    });

    // перемещение объекта на позицию вниз для сортировки записей
    $('#sort-record .sort-btn a[data-id="down"]').click(function (e) {
        obj = $(this).parent().parent().parent().parent();
        shift = obj.position().top;
        obj.insertAfter(obj.next());

        $('#sort-record > tr').each(function(index) {
            indexDiv = $(this).find('input[data-id="order"]');
            indexDiv.val(index);
            indexDiv.attr('value', index);
        });

        shift = obj.position().top - shift;
        $(window).scrollTop($(window).scrollTop() + shift)

        return false;
    });
    // перемещение объекта на позицию вверх для сортировки записей
    $('#sort-record .sort-btn a[data-id="up"]').click(function (e) {
        obj = $(this).parent().parent().parent().parent();
        shift = obj.position().top;
        obj.insertBefore(obj.prev());

        $('#sort-record > tr').each(function(index) {
            indexDiv = $(this).find('input[data-id="order"]');
            indexDiv.val(index);
            indexDiv.attr('value', index);
        });

        shift = obj.position().top - shift;
        $(window).scrollTop($(window).scrollTop() + shift);

        return false;
    });
    // перемещение объекта на первую позицию для сортировки записей
    $('#sort-record .sort-btn a[data-id="up-first"]').click(function (e) {
        obj = $(this).parent().parent().parent().parent();
        obj.parent().prepend(obj);

        $('#sort-record > tr').each(function(index) {
            indexDiv = $(this).find('input[data-id="order"]');
            indexDiv.val(index);
            indexDiv.attr('value', index);
        });

        return false;
    });
    // перемещение объекта на последнюю позицию для сортировки записей
    $('#sort-record .sort-btn a[data-id="down-last"]').click(function (e) {
        obj = $(this).parent().parent().parent().parent();
        obj.parent().append(obj);

        $('#sort-record > tr').each(function(index) {
            indexDiv = $(this).find('input[data-id="order"]');
            indexDiv.val(index);
            indexDiv.attr('value', index);
        });

        return false;
    });

    // переводит чекбок в обычный инпут
    $('input[type="checkbox"].minimal').attr('type', 'check');
});

function actionAddTR(bodyPanelID, trPanelID, removePanelID) {
    index = $('#' + bodyPanelID).attr('data-id') * 1 + 1;
    $('#' + bodyPanelID).attr('data-id', index);

    var tr = $(
        $.trim(
            $('#' + trPanelID).html()
                .replace('<!--', '')
                .replace('-->', '')
                .replace(/#index#/g, index)
        )
    );

    $('#' + removePanelID).remove();
    $('#' + bodyPanelID).append(tr);

    __initSelect2($('#' + bodyPanelID + ' .select2'));

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    // переводит чекбок в обычный инпут
    $('#' + bodyPanelID + ' input[type="checkbox"].minimal').attr('type', 'check');

    __init()

    return tr;
}

function actionAddPanel(bodyPanelID, trPanelID, removePanelID) {
    index = $('#' + bodyPanelID).attr('data-id') * 1 + 1;
    $('#' + bodyPanelID).attr('data-id', index);

    var tr = $.trim(
        $('#' + trPanelID).html()
            .replace('<script>/\*', '')
            .replace('\*/</script>', '')
            .replace(/#number#/g, index)
    );

    $('#' + removePanelID).remove();
    $('#' + bodyPanelID).append(tr);

    __initSelect2($('#' + bodyPanelID + ' .select2'));

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    // переводит чекбок в обычный инпут
    $('#' + bodyPanelID + ' input[type="checkbox"].minimal').attr('type', 'check');

    $('button[data-widget="remove"]').click(function () {
        $(this).parent().parent().parent().remove();

        return false;
    });

    return;
}

function actionFindGoods(findPanel, resultPanel, isGroup, url) {
    var datas = {};

    var arr = jQuery('#' + findPanel + ' input[name], ' + '#' + findPanel + ' select[name]');
    arr.each(function (i) {
        s = jQuery(this).attr('name');

        tmp = s.indexOf('[]');
        if(tmp < 0){
            datas[s] = jQuery(this).val();
        }else{
            s = s.substring(0, tmp);

            if(Array.isArray(datas[s])){
                datas[s].push(jQuery(this).val());
            }else{
                datas[s] = [jQuery(this).val()];
            }
        }
    });

    if(isGroup != ''){
        datas['is_group'] = isGroup;
    }

    var s = $('#' + resultPanel);
    jQuery.ajax({
        url: url,
        data: (datas),
        type: "POST",
        success: function (data) {
            s.html(data);
            initElements();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });

    return false;
}

function actionAddGoodPromo(id, shopID) {
    count = $('#good-count-' + id).val();

    var s = $('#panel-goods tbody');
    jQuery.ajax({
        url: '/cabinet/shopgood/promo',
        data: ({
            id: (id),
            shop_branch_id: (shopID),
            count: (count),
        }),
        type: "POST",
        success: function (data) {
            s.append(data);
            __init();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionAddGoodPromoGift(id, shopID) {
    count = $('#good-count-' + id).val();

    var s = $('#panel-goods-gift tbody');
    jQuery.ajax({
        url: '/cabinet/shopgood/promogift',
        data: ({
            id: (id),
            shop_branch_id: (shopID),
            count: (count),
        }),
        type: "POST",
        success: function (data) {
            s.append(data);
            __init();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionAddGoodGroup(id, shopID) {
    var s = $('#panel-group-goods tbody');
    jQuery.ajax({
        url: '/cabinet/shopgood/group',
        data: ({
            id: (id),
            shop_branch_id: (shopID),
        }),
        type: "POST",
        success: function (data) {
            s.append(data);
            __init();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionAddNewSimilar(id, shopID) {
    postfix = $('#panel-news-postfix').text();
    inputName = $('#panel-news-postfix').data('input-name');

    var s = $('#panel-news' + postfix + ' tbody');
    jQuery.ajax({
        url: '/cabinet/shopnew/similar',
        data: ({
            id: (id),
            shop_branch_id: (shopID),
        }),
        type: "POST",
        success: function (data) {
            $('#div-not-options-similar' + postfix).remove();
            if((inputName != '') &&(inputName != '_input-name_')){
                data = data.replace('name="shop_new_similar_ids[]"', 'name="' + inputName + '"');
            }
            s.append(data);
            __init();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionAddGoodSimilar(id, shopID) {
    var s = $('#panel-goods tbody');
    jQuery.ajax({
        url: '/cabinet/shopgood/similar',
        data: ({
            id: (id),
            shop_branch_id: (shopID),
        }),
        type: "POST",
        success: function (data) {
            $('#div-not-options-similar-goods').remove();
            s.append(data);
            __init();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}




function delShopBillItem(shopID, billItemID) {
    var s = $('#main_panel');
    jQuery.ajax({
        url: '/cabinet/shopbillitem/del',
        data: ({
            shop_id: (shopID),
            id: (billItemID),
            is_main: (1),
            url: ('/cabinet/shopbill/edit'),
        }),
        type: "POST",
        success: function (data) {
            s.html(data);
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function saveShopBillItem(shopID, billItemID) {
    count = $('#count-' + billItemID).val();

    var s = $('#main_panel');
    jQuery.ajax({
        url: '/cabinet/shopbillitem/save',
        data: ({
            shop_id: (shopID),
            id: (billItemID),
            count: (count),
            is_main: (1),
            url: ('/cabinet/shopbill/edit'),
        }),
        type: "POST",
        success: function (data) {
            s.html(data);
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function setShopBillStatus(shopID, billID, statusID) {
    s = $('#record_' + billID);

    jQuery.ajax({
        url: '/cabinet/shopbill/save',
        data: ({
            id: (billID),
            shop_id: (shopID),
            bill_status_id: (statusID),
            json: (true),
        }),
        type: "POST",
        success: function (data) {
            var obj = jQuery.parseJSON($.trim(data));
            if (obj.error) {
            } else {
                switch (statusID) {
                    case 6:
                        s.find('a[data-name="status-apply"]').remove();
                        break;

                    case 7:
                        s.find('a[data-name="status-collect"]').remove();
                        break;

                    case 8:
                        s.find('a[data-name="status-ready"]').remove();
                        break;

                    case 9:
                        s.find('a[data-name="status-delivery"]').remove();
                        break;

                    case 10:
                        s.find('a[data-name="status-delivery"]').remove();
                        s.find('a[data-name="status-ready"]').remove();
                        s.find('a[data-name="status-finish"]').remove();
                        s.find('a[data-name="status-apply"]').remove();
                        s.find('a[data-name="status-collect"]').remove();
                        break;

                    case 11:
                        s.find('a[data-name="status-delivery"]').remove();
                        s.find('a[data-name="status-ready"]').remove();
                        s.find('a[data-name="status-collect"]').remove();
                        s.find('a[data-name="status-finish"]').remove();
                        s.find('a[data-name="status-apply"]').remove();
                        s.find('a[data-name="status-cancel"]').remove();
                        break;
                }
            }
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionDeletePromo(name) {
    $('#' + name).remove();
}

function actionDelObject(url, id) {
    var s = $('#record_' + id+ ' a[buttom_list="del"]');
    jQuery.ajax({
        url: url,
        data: ({
            id: (id),
            is_main: (1),
        }),
        type: "POST",
        success: function (data) {
            s.text('восстановить');
            s.attr('is-undel', 1);
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionUnDelObject(url, id) {
    var s = $('#record_' + id+ ' a[buttom_list="del"]');
    jQuery.ajax({
        url: url,
        data: ({
            id: (id),
            is_undel: (1),
            is_main: (1),
        }),
        type: "POST",
        success: function (data) {
            s.text('удалить');
            s.removeAttr('is-undel');
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionEditObject(url, id) {
    var s = $('#main_panel');
    jQuery.ajax({
        url: url,
        data: ({
            id: (id),
            is_main: (1),
        }),
        type: "POST",
        success: function (data) {
            s.text('');
            s.append(data);
            initElements();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function actionSaveObject(url, id, editPanelID, isLoadData, isClose, isShowURL) {
    var datas = {};

    var arr = jQuery('#' + editPanelID + ' input[name], ' + '#' + editPanelID + ' select[name]');
    arr.each(function (i) {
        s = jQuery(this).attr('name');

        tmp = s.indexOf('[]');
        if(tmp < 0){
            datas[s] = jQuery(this).val();
        }else{
            s = s.substring(0, tmp);

            if(Array.isArray(datas[s])){
                datas[s].push(jQuery(this).val());
            }else{
                datas[s] = [jQuery(this).val()];
            }
        }
    });

    var arr = jQuery('#' + editPanelID + ' textarea[name]');


    var arr = jQuery('#' + editPanelID + ' textarea[name]');
    arr.each(function (i) {
        s = jQuery(this).attr('name');

        var value = '';
        try {
            if(jQuery(this).attr('is_editor') == 1){
                value = editor.getValue();
            }else {
                value = CKEDITOR.instances[s].getData();
            }
        } catch (err) {
            value = jQuery(this).val();
        }

        tmp = s.indexOf('[]');
        if(tmp < 0){
            datas[s] = value;
        }else{
            s = s.substring(0, tmp);

            if(Array.isArray(datas[s])){
                datas[s].push(value);
            }else{
                datas[s] = [value];
            }
        }
    });

    if(isClose == false) {
        datas['is_close'] = false;
    }else {
        datas['is_close'] = true;
    }

    datas['id'] = id;
    if(isShowURL === true){
        alert(url + $.param(datas));
    }

    datas['is_main'] = true;
    var s = $('#main_panel');
    jQuery.ajax({
        url: url,
        data: (datas),
        type: "POST",
        success: function (data) {
            if (isLoadData) {
                s.text('');
                s.append(data);
                initElements();
            }
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function addPanel(idFrom, idTo) {
    var form = $('#' + idFrom);
    var index = form.data('index');
    form.data('index', Number(index) + 1);

    var tmp = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));

    $('#' + idTo).append(tmp);

    __initSelect2($(".select2"));
    initDelDiv();
}

function actionTableFind(url, filterID, tableID, isShowURL) {
    var datas = {};
    if(filterID != '') {
        var arr = jQuery('#' + filterID + ' input[name],' + '#' + filterID + ' select[name]');
        arr.each(function (i) {
            datas[jQuery(this).attr('name')] = jQuery(this).val();
        });
    }

    var s = jQuery('#' + tableID);
    datas['is_table'] = true;
    datas['is_main'] = true;

    if(isShowURL === true){
        alert(url + '&' + $.param(datas));
    }

    jQuery.ajax({
        url: url,
        data: (datas),
        type: "POST",
        success: function (data) {

            s.text('');
            s.append(data);
            initElements();
        },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
    });
}

function addItem(num) {
    var data = $("#child" + num).children('select').val();
    var tmp = $("#child" + num).attr('textarea');
    $('#' + tmp).insertAtCaret(data);

    $('#' + tmp).parent().children('div').children('textarea').insertAtCaret(data);
    //$('#'+tmp).parent().children('div').children('textarea').
    //document.getElementById(tmp+num).innerHTML = data;
}

function addData(num) {
    var data = $("#child" + num).children('select').val();
    var tmp = $("#child" + num).attr('textarea');
    $('#' + tmp).insertAtCaret("<?php echo $data->values['" + data + "']; ?>");
}

function addView(num) {
    var data = $("#child" + num).children('select').val();
    var tmp = $("#child" + num).attr('textarea');
    $('#' + tmp).insertAtCaret("<?php echo trim($siteData->globalDatas['view::" + data + "']); ?>");
}

function addUrl(num) {
    var data = $("#child" + num).children('select').val();
    var tmp = $("#child" + num).attr('textarea');
    $('#' + tmp).insertAtCaret("<?php echo $siteData->urlBasic;?>/" + data);
}

jQuery.fn.extend({
    insertAtCaret: function (myValue) {
        return this.each(function (i) {
            if (document.selection) {
                // Для браузеров типа Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                // Для браузеров типа Firefox и других Webkit-ов
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});

function initUniqueInput() {
    $(document).on('input', '[unique="1"]', function () {
        rubNumber = Math.floor(Math.random() * (10000 - 1 + 1)) + 1;

        if($(this).attr('run') == 1){
            return false;
        }
        $(this).attr('run', 1);

        parent = $(this).parent();

        parent.find('span[data-id="check"]').remove();
        parent.prepend('<span data-id="check" style="float: right; margin-top: 1px;" class="label label-warning">Проверка</span>');

        el = $(this);

        url = $(this).attr('href');
        field = $(this).attr('name');
        msg = $(this).attr('unique-error');
        id = $(this).attr('unique-current-id');


        setTimeout(function () {
            el.removeAttr('run');
            value = el.val();

            $.ajax({
                url: url,
                data: ({
                    field: (field),
                    value: (value),
                    id: (id),
                }),
                type: "POST",
                success: function (data) {
                    if(el.attr('run') == 1){
                        return false;
                    }

                    parent.find('span[data-id="check"]').remove();
                    parent.find('span[class="error-message"]').remove();

                    var obj = jQuery.parseJSON($.trim(data));
                    if (obj.error) {
                        parent.addClass('has-error');
                        parent.append('<span class="error-message">' + msg + '</span>');
                    } else {
                        parent.removeClass('has-error');
                    }
                },
                error: function (data) {
                    if(el.attr('run') == 1){
                        return false;
                    }
                    parent.find('span[data-id="check"]').remove();
                    parent.find('span[class="error-message"]').remove();

                    parent.addClass('has-error');
                    parent.append('<span class="error-message">Server error</span>');
                }
            });
        }, 2000); // время в мс

        return false;
    });
}

function initTableClick() {
    $('th[class="sorting"],th[class="sorting_asc"],th[class="sorting_desc"]').click(function () {
        url = $(this).attr('href');
        url = url.replace('%5D', ']').replace('%5B', '[');

        var s = $(this).parent().parent().parent().parent();
        $.ajax({
            url: url,
            data: ({}),
            type: "POST",
            success: function (data) {
                s.text('');
                s.append(data);
                initElements();
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    });
}

function initSaveTR() {
    $('td a[buttom-tr="save"]').click(function () {
        url = $(this).attr('href');
        id = $(this).attr('data-id');

        var datas = {};

        var s = $(this);
        var arr = $(this).parent().parent().find('input[name]');
        arr.each(function (i) {
            datas[jQuery(this).attr('name')] = jQuery(this).val();
        });

        var arr = $(this).parent().parent().find('textarea[name]');
        arr.each(function (i) {
            tmp = jQuery(this).attr('name');
            datas[tmp] = CKEDITOR.instances[tmp].getData();
        });

        datas['id'] = id;
        jQuery.ajax({
            url: url,
            data: (datas),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (!obj.error) {
                    s.attr('data-id', obj.values.id);
                    s.attr('class', 'btn btn-default btn-sm checkbox-toggle');
                    s.parent().find('a[buttom-tr="del"]').attr('data-id', obj.values.id);
                }
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });

        return false;
    });

    $('td input[name]').change(function () {
        $(this).parent().parent().find('td a[buttom-tr="save"]').attr('class', 'btn btn-primary btn-sm checkbox-toggle');

        return false;
    });

    $('td a[buttom-tr="del"]').click(function () {
        url = $(this).attr('href');
        id = $(this).attr('data-id');

        var s = $(this).parent().parent();
        if (!(id > 0)) {
            s.remove();
            return false;
        }

        jQuery.ajax({
            url: url,
            data: ({
                id: (id),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (!obj.error) {
                    s.remove();
                }
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });

        return false;
    });

    $('select[name="email_type_id"]').change(function () {
        id = $(this).val();
        $('#panels-fields div[data-id="fields"]').attr('hidden', 'hidden');
        $('#panel-fields-' + id).removeAttr('hidden');
        return false;
    });
    id = $('select[name="email_type_id"]').val();
    if(id > 0) {
        $('#panels-fields div[data-id="fields"]').attr('hidden', 'hidden');
        $('#panel-fields-' + id).removeAttr('hidden');
    }

    $('td a[buttom_list="del"]').click(function () {
        url = $(this).attr('href');
        id = $(this).attr('data-id');

        isUndel = $(this).attr('is-undel');
        if(isUndel == 1){
            actionUnDelObject(url, id);
        }else {
            actionDelObject(url, id);
        }

        return false;
    });

    if($('#interface-data').attr('java-url') != 0) {
        $('td a[buttom_list="edit"]').click(function () {
            url = $(this).attr('href');
            id = $(this).attr('data-id');
            actionEditObject(url, id);

            return false;
        });
    }

    if($('#interface-data').attr('java-url') != 0) {
        $('td a[buttom_list="new"]').click(function () {
            url = $(this).attr('href');
            actionEditObject(url, 0);

            return false;
        });
    }

    $('td input[name="list-order"]').change(function () {
        url = $(this).parent().parent().find('input[name="set-is-public"]').attr('href');
        url = url.replace('edit', 'save');
        order = $(this).val();

        jQuery.ajax({
            url: url,
            data: ({
                order: (order),
                json: (true)
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });

        return false;
    });
}

function initCreateSite(){
    $('a[view="1"]').click(function () {
        data = "<?php echo $data['view::" + $(this).attr('data-id') + "']; ?>";

        tmp = $(this).attr('textarea');
        $('#' + tmp).insertAtCaret(data);
        return false;
    });

    $('a[view="2"]').click(function () {
        data = "<?php echo $data->values['" + $(this).attr('data-id') + "']; ?>";

        tmp = $(this).attr('textarea');
        $('#' + tmp).insertAtCaret(data);
        return false;
    });

    $('a[view="3"]').click(function () {
        data = $(this).attr('data-id');
        tmp = $(this).attr('textarea');
        $('#' + tmp).insertAtCaret(data);
        return false;
    });
}



function initCombobox() {
    $('a[list="1"]').click(function () {
        data = $(this).attr('data-id');
        text = $(this).text();

        n = $(this).parent().parent().parent();
        n.attr('class', 'btn-group');
        n = n.children('button[list="1"]');
        n.text(text);
        m = n.parent().children('input[list="1"]');
        m.attr("value", data);

        n.parent().parent().children('a[view="1"]').attr('data-id', data);
        n.parent().parent().children('a[view="2"]').attr('data-id', data);
        return false;
    });

    $('select[name="shop_attribute_catalod_id"]').change(function () {
        var tr = $.trim($('#tr_panel').html().replace('<!--', '').replace('-->', ''));
        $('#body_panel').html('');

        var arr = $(this).val().split(',');
        $.each(arr, function (i, n) {
            if(n > 0) {
                s = 'data-id="' + n + '"';

                s = tr.replace(s, s + ' selected').replace('list="attribute_names', 'list="attribute_names_' + n);
                $('#body_panel').append(s);
            }
        });

        initElements();

        return;
    });

    $('select[name="shop_information_data_catalog_id"]').change(function () {
        id = $(this).val();

        $('div[name="options"]').each(function( index ) {
            if($(this).attr('data-id') == id){
                $(this).removeAttr('hidden');
                tmp = $(this).find('input');
                tmp.attr('name', tmp.attr('id'));
            }else{
                $(this).attr('hidden', '');
                $(this).find('input').removeAttr('name');
            }
        });
    });
    if($.find('select[name="shop_information_data_catalog_id"]').length > 0) {
        id = $('select[name="shop_information_data_catalog_id"]').val();

        $('div[name="options"]').each(function( index ) {
            if($(this).attr('data-id') == id){
                $(this).removeAttr('hidden');
                tmp = $(this).find('input');
                tmp.attr('name', tmp.attr('id'));
            }else{
                $(this).attr('hidden', '');
                $(this).find('input').removeAttr('name');
            }
        });
    }

    $('select[type="attribute_catalog_ids"]').change(function () {
        id = $(this).val();
        $(this).parent().parent().find('td input[type="attribute_names"]').attr('list', 'attribute_names_' + id);

        return;
    });
}

function initDelDiv() {
    $('a[data-action="del-view"]').click(function () {
        $(this).parent().parent().remove();
        return false;
    });
}

function initLoadImageAddition() {
    $('.box-image').dmUploader({
        url: '/cabinet/file/loadimage',
        dataType: 'json',
        maxFileSize: 10 * 1024 * 1014,
        allowedTypes: 'image/*',
        onBeforeUpload: function (id) {
            output = $(this).find('.box-body ul li');
            output.html('<img src="/css/_component/loadimage_v2/loader.gif">').show();
        },
        onUploadSuccess: function (id, response) {
            output = $(this).find('.box-body ul li');

            if (response.type == "message") {
                output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + response.data.txt + '</span>');
            }else{
                if (response.type == "upload") {
                    output.html('<img src="' + response.data.url + '">');

                    input =  $(this).find('input[data-id="file-url"]');
                    input.attr('value', response.data.file);
                    input.val(response.data.file);

                    input =  $(this).find('input[data-id="file-name"]');
                    input.attr('value', response.data.file_name);
                    input.val(response.data.file_name);

                    input =  $(this).find('input[data-id="file-id"]');
                    input.attr('value', 0);
                    input.val(0);
                }else{
                    output.html('')
                }
            }
        },
        onUploadError: function (id, message) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + "Файл: " + id + " не загрузился: " + message + '</span>');
        },
        onFileTypeError: function (file) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Загружать можно только PNG и JPEG.</span>');
        },
        onFileSizeError: function (file) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Файл слишком большой (максимальный размер 10МБ).</span>');
        },
        onFallbackMode: function (message) {
            output = $(this).find('.box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Ваш браузер не поддерживается.</span>');
        }
    });

    $('a[class="dropzone-del"]').click(function () {
        $(this).parent().attr('hidden', 'hidden');
        $(this).parent().find('div input[data-id="file-isdel"]').attr('value', '1');

        return false;
    });
}

function initLoadimage() {
    initLoadImageAddition();
    $('div[name="add-images"]').dmUploader({
        url: '/cabinet/file/loadimage',
        dataType: 'json',
        maxFileSize: 10 * 1024 * 1014,
        allowedTypes: 'image/*',
        onBeforeUpload: function (id) {
            postfix = $(this).data('postfix');

            output = $('#sort-images' + postfix);

            index = $('#sort-images' + postfix + ' > div').length + 1;

            panel = $.trim(
                $('#add-image-panel' + postfix).html()
                    .replace('<!--', '')
                    .replace('-->', '')
                    .replace('#column#', output.attr('column'))
                    .replace('#name#', 'div-image-' + postfix + id)
                    .replace(/#index#/g, index)
            );
            output.append(panel).show();

            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<img src="/css/_component/loadimage_v2/loader.gif">').show();
            __init;
        },
        onUploadSuccess: function (id, response) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');

            if (response.type == "message") {
                output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + response.data.txt + '</span>');
            }else{
                if (response.type == "upload") {
                    output.html('<img src="' + response.data.url + '">');

                    input =  $('div[name="div-image-' + postfix + id + '"] input[data-id="file-url"]');
                    input.attr('value', response.data.file);
                    input.val(response.data.file);

                    input =  $('div[name="div-image-' + postfix + id + '"] input[data-id="file-name"]');
                    input.attr('value', response.data.file_name);
                    input.val(response.data.file_name);

                }else{
                    output.html('')
                }
            }
            $('div[name="div-image-' + id + '"]').removeAttr('name');
        },
        onUploadError: function (id, message) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">' + "Файл: " + id + " не загрузился: " + message + '</span>');
        },
        onFileTypeError: function (file) {
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Загружать можно только PNG и JPEG.</span>');
        },
        onFileSizeError: function (file) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Файл слишком большой (максимальный размер 10МБ).</span>');
        },
        onFallbackMode: function (message) {
            postfix = $(this).data('postfix');
            output = $('div[name="div-image-' + postfix + id + '"] .box-body ul li');
            output.html('<span class="error">Ошибка загрузки.</span><br><span class="text-red">Ваш браузер не поддерживается.</span>');
        }
    });
}

function initCheckbox() {
    //Flat red color scheme for iCheck
    //Flat red color scheme for iCheck
   /* $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').on('ifChecked', function (event) {
        $(this).attr('value', '1');
        $(this).attr('checked', '');
    }).on('ifUnchecked', function (event) {
        $(this).attr('value', '0');
        $(this).removeAttr('checked');
    }).iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
    }).removeAttr('class');

    $('input[name="set_is_public"]').on('ifChecked', function (event) {
        isPublic = 1;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_public: (isPublic),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    }).on('ifUnchecked', function (event) {
        isPublic = 0;
        url = $(this).attr('href');

        jQuery.ajax({
            url: url,
            data: ({
                is_public: (isPublic),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
        });
    });*/


    $('#find_panel input').keyup(function (event) {
        if(event.keyCode == 13){
            document.getElementById('button-search').click();
        }
    });

    $('#find_panel select').keyup(function (event) {
        if(event.keyCode == 13){
            document.getElementById('button-search').click();
        }
    });
}

function initElements() {
    $.widget.bridge('uibutton', $.ui.button);

    initCheckbox();

    initUniqueInput();

    initTableClick();
    initSaveTR();
    initLoadimage();

    initCombobox();
    initDelDiv();

    initCreateSite();

    $("input").focus(function(){
        if(this.value == this.defaultValue){
            this.select();
        }
    });

    jQuery.each($('select'), function() {
        id = $(this).attr('select');
        if(id > 0) {
            $(this).val(id);
        }
    });

    if($.find('#upload ul').length > 0) {
        initLoadFile();
    }

    $('input[data-type="mobile"]').inputmask({
        mask: "+7(799) 999 99 99"
    }).attr('autocomplete', 'off');
}

$(document).ready(function () {
    initElements();

    $('[data-action="parse-site"]').click(function () {
        var modal = $(this).data('modal');
        $(modal).remove();

        var url = $(this).data('href');

        jQuery.ajax({
            url: url,
            data: ({}),
            type: "POST",
            success: function (data) {
                $('body').append(data);
                $(modal).modal('show');
                __initSelect2($(modal).find(".select2"));
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });



    if($('#interface-data').attr('java-url') != 0) {
        $('a[menu="1"]').click(function () {
            url = $(this).attr('href');
            url = url.replace('%5D', ']').replace('%5B', '[');

            var els = $('i[class="fa fa-circle"]');

            var el = $(this).children('i');
            var s = $('#main_panel');
            $.ajax({
                url: url,
                data: ({
                    is_main: (1)
                }),
                type: "POST",
                success: function (data) {
                    els.attr('class', 'fa fa-circle-o');
                    el.attr('class', 'fa fa-circle');

                    s.text('');
                    s.append(data);

                    initElements();
                },
            error: function (data) {    
 		console.log(data.responseText);    
	     }
            });

            return false;
        });
    }
});
