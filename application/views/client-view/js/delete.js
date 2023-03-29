$(document).ready(function () {
    /**
     * Удаляем строку таблицы
     * на кнопки параметры:
     * data-action="remove-tr" data-parent-count="количество раз получить родителя"
     */
    $('[data-action="remove-tr"]').click(function () {
        var n = parseInt($(this).data('parent-count'));
        var parent = $(this);
        for (i = 0; i < n; i++){
            parent = parent.parent();
        }

        parent.remove();

        return false;
    });
});