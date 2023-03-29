/**
 * Отправляем данные на сервер без перезагрузки страницы и открытием модального окна
 * отлавливаем нажание кнопки
 * #button-send-data - id="button-send-data" на кнопке
 * #form-send-data - id="form-send-data" на элементе формы
 * #modal-send-data-finish - id="modal-send-data-finish" на модальном окне, которое нужно показать после отправлки данных
 */
$('#button-send-data').click(function (e) {
    e.preventDefault();

    var form = $('#form-send-data');
    var url = form.attr('action');

    var params = form.serializeArray();

    jQuery.ajax({
        url: url,
        data: params,
        type: "POST",
        success: function (data) {
            $('#modal-send-data-finish').modal('show');
        },
        error: function (data) {
            console.log(data.responseText);
        }
    });
});

/**
 * Проверка поля на то, что это является e-mail
 */
var s = $(this).val();
if ((s == '') || (!(/^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/i.test(s)))){
    // ошибка
}