/** глобальная переменная */
window.boolka;
/** Обновить связочную модель */
function update_mc(obj) {
    var classNameLower   = obj.data('class-name');
    /** Если отсутствует класс */
    if(!classNameLower){
        displayMessage('update_mc: Класс не определен','danger');
        return false;
    }
    /** Код */
    var id  = obj.data('id'); // classNameLower + '-
    /** Имя класса */
    var className           = getClassName(classNameLower);
    // console.log('[name="'+ className +'[name]"][data-id="' + id + '"]');
    /** Параметр - name */
    var param     = $('body').find('[name="'+ className +'[name]"][data-id="' + id + '"]'); // -' + classNameLower + '
    /** Ругательное сообщение */
    if(!warningMessage(param, 'Параметр не определен')){
        loadingFlagLivings = false;ou
        return false;
    }
    /** Значение value */
    var value       =    param.val();
    // parseFloat(); - для цен
    $.ajax({
        type: 'post',
        url : '/smanager/' + classNameLower + '/update',
        data: {
            id                  :   id,
            name                :   value,
            YII_CSRF_TOKEN      :   csrfToken,
        },
        success: function (data){
            // console.log('updateSuccess: ' + data);
            displayMessage('Элемент успешно обновлен', 'success');
            // $('form')[0].reset();
            loadingFlagTarifs = false;
            /** реинициализация служебных скриптов */
            reinitialization();
        },
        error: function (){
            displayMessage('Error', 'danger');
            loadingFlagTarifs = false;
        }
    });
    return true;
}
/** Вытащить все связанные формы по формам */
function get_mc_forms(tenant_id, classNameLower){
    /** Класс не определен */
    if(!classNameLower) {
        displayMessage('crud_mc: Класс не определен','danger');
        return false;
    }
    /** Если фирма не определена */
    if(!tenant_id) {
        displayMessage('Не получен идентификатор фирмы');
        loadingFlagLivings = false;
        return false;
    }
    // console.log('node_id: ' + node_id);
    // return false;
    $.ajax({
        type: "post",
        // @todo  - реализация данного метода в Классе внешнего действия
        url : '/smanager/' + classNameLower + '/getForms', // getTarifsForms
        // async: false,
        data: {
            tenant_id               :    tenant_id,   // or id
            YII_CSRF_TOKEN          :    csrfToken
        },
        success: function (data){
            // console.log(data);
            $('#' + classNameLower + '-table').empty();
            $('#' + classNameLower + '-table').append(data);
            /** скидываем блок */
            loadingFlagTarifs = false;
            /** реинициализация служебных скриптов */
            reinitialization();
        },
        error: function () {
            displayMessage('Error', 'danger');
            loadingFlagTarifs = false;
        }
    });
}
/** Получение имени класса в нижнем регистре  */
function getClassName(classNameLower){
    // console.log(classNameLower);
    // return false;
    var className  = classNameLower.charAt(0).toUpperCase()
        + classNameLower.substr(1).toLowerCase();
    return className;
}
/** Crud над связочными таблицами */
function crud_mc(obj){
    /** Флаг загрузки */
    var loadingFlagTarifs  = false;
    /** Сценарий */
    var scenario            = obj.data('scenario');
    /** Название класса в нижнем регистре */
    var classNameLower      = obj.data('class-name');
    /** Название класса с большой буквы */
    var className           = getClassName(classNameLower);
    /** Фирма */
    var tenant_id = obj.data('tenant-id');
    console.log(tenant_id);
    /** Класс не определен */
    if(!classNameLower){
        displayMessage('crud_mc: Класс не определен','danger');
        return false;
    }
    /** Если обновление */
    if (scenario == 'update')
        /** Обновляем список связанных данных (форм) */
        update_mc(obj);
    /** если добавление */
    else {
        // @todo оптимизировать в функцию и className
        /** добавить модель */
        if (loadingFlagTarifs) {
            displayMessage(monsterClickMessage, 'danger');
            return false;
        }
        /** выставляем блокировку */
        loadingFlagTarifs = true;
        // var room_index = $(this).data('room-index');
        /** Кол-во строк с формами */
        var count   = $('tr.'+ classNameLower +'-form').size();
        /**  Определение текущего идекса*/
        var index   = count ? count + 1 : 1;
        //  var room_id = parseInt($(this).attr('data-room-id'));
        // console.log('room_id: ' + room_id);
        /** Если комната отсутствует */
        // if (!room_id){
        //     displayMessage('Укажите идентификатор номера', 'warning');
        //     return false;
        // }
        /** Если индекс отсутствует */
        if (!index) {
            displayMessage('Укажите идентификатор', 'warning');
            return false;
        }
        /** Если модуль админа */
        // if(module_id == 'sadmin'){
        //     /** Переопределяем код фирмы, то берем из формы */
        //     var tenant_id = null;
        // }
        // console.log('...');
        // return false;
        $.ajax({
            type: 'post',
            url : '/smanager/' + classNameLower + '/create',
            data: $('#' + classNameLower + '-form').serialize() + '&tenant_id='+tenant_id+'&index=' + index,
            success: function (data) {
                // co(data);
                displayMessage('Элемент успешно добавлен');
                /** Посылаем кнопку или код фирмы */
                // get_mc_forms(obj);
                get_mc_forms(obj.data('tenant-id'), obj.data('class-name'));
                // @todo Определить в верстке узел
                var nodes_count     = $('body').find('input[name="' + className + '['+classNameLower+'_count]"]');
                var updated_count   = parseInt(nodes_count.val()) + 1;
                nodes_count.val(updated_count);
                $('#nodes_count_view').text(updated_count);
                $("#tarifs-form").trigger('reset');
                // $('form')[0].reset();
                loadingFlagTarifs   = false;
                /** реинициализация служебных скриптов */
                reinitialization();
            },
            error: function () {
                displayMessage('Error', 'danger');
                loadingFlagTarifs = false;
            }
        });
        return true;
    }
}
/** Удалить связанную модель */
function delete_mc(obj){
    /** Название класса в нижнем регистре */
    var classNameLower      = obj.data('class-name');
    /** id Элементв */
    var id          = parseInt(obj.data('id'));  //classNameLower + '-
    if(!id){
        console.log('id Error');
        return false
    }
    /** Фирма */
    // var tenant_id   = parseInt(obj.data('tenant-id'));
    /** кол-во гостей в номере */
    var nodes_count = parseInt(obj.attr('data-count')); // '+classNameLower+'-
    $.ajax({
        type: 'post',
        url : '/smanager/' + classNameLower + '/delete/id/' + id,
        data: {
            YII_CSRF_TOKEN  :   csrfToken,
            // id              :   id,
        },
        success: function (data){
            // console.log(data);
            displayMessage('Элемент успешно удален', 'success');
            $('.'+classNameLower+'-tr[data-id="'+id+'"]').remove();
            // $('.' + classNameLower + '-form-container').has('[data-id="' + id + '"]').remove(); // -' + classNameLower + '
            // /** удаление на клиенте всех лишниих блоков */
            // $('body').find('.delete-mc').each(function() { //  classNameLower
            //     var tmp_nodes_count = parseInt($(this).data(classNameLower + '-count'));
            //     if(tmp_nodes_count > nodes_count){
            //         $('.' + classNameLower + '-form-container')
            //             .has('[data-' + nodes + '-count="' + tmp_nodes_count + '"]')
            //             .remove();
            //     }
            // });

            /** Сбрасывание флага */
            loadingFlagTarifs = false;
            /** реинициализация служебных скриптов */
            reinitialization();
        },
        error: function () {
            displayMessage('Error', 'danger');
            loadingFlagTarifs = false;
        }
    });
    return true;
}

/** При загрузке документа */
$(document).ready(function() {
    /** Обновить телефон */
    $('body').on('click', '.crud-mc', function(e){
        e.preventDefault();
        crud_mc($(this));
    });
    /** Удалить элемент */
    $('body').on('click', '.delete-mc', function(e){
        e.preventDefault();
        /** удаление элемента */
        delete_mc($(this));
    });
});
