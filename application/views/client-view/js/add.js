/**
 * Добавляем элемент
 * __init() - для инициализации необходимых действий
 * #index# - меняется на следующий за $('#'+from).data('index')
 * @param from - откуда (комментарий)
 * @param to - куда
 * @param isLast - в конец?
 */
function addElement(from, to, isLast){
    var index = $('#'+from).data('index') * 1 + 1;
    $('#'+from).data('index', index);

    var html = $('#'+from).html().replace('<!--', '').replace('-->', '').replace(/#index#/g, index);

    if(isLast){
        $('#'+to).append(html);
    }else{
        $('#'+to).prepend(html);
    }
    __init();
}
