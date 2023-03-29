<div id="tax-return-200-data-edit-data-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <?php
    $view = View::factory('tax/client/35/_shop/tax/return/200/one/data');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->formName = 'tax-return-200-data-edit';
    echo Helpers_View::viewToStr($view);
    ?>
    <script>
        $(document).ready(function () {
            __initTable();

            $('#tax-return-200-data-edit-data-record form').on('submit', function(e){
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
                            $('#tax-return-200-data-edit-data-record').modal('hide');
                            $('#tax-return-200-data-table').bootstrapTable('updateByUniqueId', {
                                id: obj.values.id,
                                row: obj.values
                            });
                            $that.find('input[type="text"], textarea').val('');
                            $that.find('input[type="checkbox"]').removeAttr("checked");

                            $.notify("Запись сохранена");
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });

            $('#tax-return-200-data-edit-data-record form select[name="half_year"], #tax-return-200-data-edit-data-record form input[name="year"]').change(function () {
                var half_year = $('#tax-return-200-data-edit-data-record form select[name="half_year"]').val();
                var year = $('#tax-return-200-data-edit-data-record form input[name="year"]').val();

                jQuery.ajax({
                    url: '/tax/shopworkerwage/six_month',
                    data: ({
                        'half_year': (half_year),
                        'year': (year),
                        'is_owner': (0),
                    }),
                    type: "POST",
                    success: function (data) {
                        $('#tax-return-200-data-edit-data-wages').html(data);
                        __initTr();
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });


                jQuery.ajax({
                    url: '/tax/shopworkerwage/six_month',
                    data: ({
                        'half_year': (half_year),
                        'year': (year),
                        'is_owner': (1),
                    }),
                    type: "POST",
                    success: function (data) {
                        $('#tax-return-200-data-edit-data-wages-owner').html(data);
                        __initTr();
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                jQuery.ajax({
                    url: '/tax/shopcommercial/get_amount',
                    data: ({
                        'half_year': (half_year),
                        'year': (year),
                    }),
                    type: "POST",
                    success: function (data) {
                        $('#tax-return-200-data-edit-data-record input[name="revenue"]').val(data).trigger('change');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });
        });
    </script>
</div>
