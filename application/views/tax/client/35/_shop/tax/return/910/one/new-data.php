<div id="tax-return-910-data-new-data-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <?php
    $view = View::factory('tax/client/35/_shop/tax/return/910/one/data');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->formName = 'tax-return-910-data-new';
    echo Helpers_View::viewToStr($view);
    ?>
    <script>
        $(document).ready(function () {
            __initTable();

            $('#tax-return-910-data-new-data-record form').on('submit', function(e){
                e.preventDefault();
                var $that = $(this),
                    formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
                url = $(this).attr('action')+'?json=1';

                jQuery.ajax({
                    url: url,
                    data: formData,
                    type: "POST",
                    contentType: false, // важно - убираем форматирование данных по умолчанию
                    processData: false, // важно - убираем преобразование строк по умолчанию
                    success: function (data) {
                        var obj = jQuery.parseJSON($.trim(data));
                        if (!obj.error) {
                            $('#tax-return-910-data-new-data-record').modal('hide');

                            var table = $('#tax-return-910-data-table');
                            table.bootstrapTable('insertRow', {
                                index: 0,
                                row: obj.values
                            });
                            table.bootstrapTable('uncheckAll');
                            table.bootstrapTable('checkBy', {field:'id', values:[obj.values.id]});

                            $that.find('input[type="text"], input[type="date"], textarea').val('');
                            $that.find('input[type="checkbox"]').removeAttr("checked");

                            $.notify("Запись сохранена");

                            $('button[data-id="tax-return-910-show"]').click();
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });
        });
    </script>
</div>
