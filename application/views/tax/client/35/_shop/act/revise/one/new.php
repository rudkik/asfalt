<div id="act-revise-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление акт сверки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopactrevise/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Номер</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group margin-0">
                                        <input name="number" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid" placeholder="Номер" id="number" type="text" readonly>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <label for="date_from" class="col-3 col-form-label">Дата от</label>
                                                <div class="col-9">
                                                    <div class="form-group margin-0">
                                                        <input name="date_from" data-validation="length" class="form-control" id="act-revise-new-date_from" type="datetime" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <label for="date_to" class="col-3 col-form-label">Дата до</label>
                                                <div class="col-9">
                                                    <div class="form-group margin-0">
                                                        <input name="date_to" data-validation="length" class="form-control" id="act-revise-new-date_to" type="datetime" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="act-revise-new-shop_contractor_id" class="col-2 col-form-label">Контрагент</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <select name="shop_contractor_id" id="act-revise-new-shop_contractor_id" class="form-control ks-select" data-parent="#act-revise-new-record" data-parent="#act-revise-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Без контрагента</option>
                                    <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="act-revise-new-shop_contract_id" class="col-2 col-form-label">Договор</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <select name="shop_contract_id" id="act-revise-new-shop_contract_id" class="form-control ks-select" data-parent="#act-revise-new-record" style="width: 100%">
                                    <option value="-1" data-id="-1">Без договора</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="act-revise-new-items" class="form-group row">
                        <?php echo $siteData->globalDatas['view::_shop/act/revise/item/list/index']; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            </form>
        </div>
    </div>
    <script>
        function getItems() {
            var form = $('#act-revise-new-record form');

            var contractorID = form.find('select[name="shop_contractor_id"]').val();
            var contractID = form.find('select[name="shop_contract_id"]').val();
            var dateFrom = form.find('input[name="date_from"]').val();
            var dateTo = form.find('input[name="date_to"]').val();

            var s = contractorID + '_'+contractID+'_'+dateFrom+'_'+dateTo;
            if (form.data('select') == s){
                return false;
            }
            form.data('select', s);

            if (contractorID < 1){
                return true;
            }
            jQuery.ajax({
                url: '/tax/shopactrevise/get_items',
                data: ({
                    'shop_contractor_id': (contractorID),
                    'shop_contract_id': (contractID),
                    'date_from': (dateFrom),
                    'date_to': (dateTo)
                }),
                type: "POST",
                success: function (data) {
                    $('#act-revise-new-items').html(data);
                },
                error: function (data) {
                    console.log(data.responseText);
                    form.data('select', '');
                }
            });
        }
        $(document).ready(function () {
            __initTable();

            $('#act-revise-new-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#act-revise-new-record form').on('submit', function(e){
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
                            $('#act-revise-new-record').modal('hide');
                            $('#act-revise-data-table').bootstrapTable('insertRow', {
                                index: 0,
                                row: obj.values
                            });
                            $that.find('input[type="text"], input[type="date"], textarea').val('');
                            $that.find('select').val('0');
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

            $('#act-revise-new-record form select[name="shop_contractor_id"]').change(function () {
                var id = $(this).val();

                if (id > 0) {
                    jQuery.ajax({
                        url: '/tax/shopcontract/list',
                        data: ({
                            'shop_contractor_id': (id),
                        }),
                        type: "POST",
                        success: function (data) {
                            var tmp = $('#act-revise-new-record form select[name="shop_contract_id"]');
                            var s = tmp.val();
                            tmp.html('<option value="-1" data-id="-1">Без договора</option>' + data);

                            if (s >= 0) {
                                tmp.val(-1);
                            }
                            getItems();
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                }else{
                    var tmp = $('#act-revise-new-record form select[name="shop_contract_id"]');
                    if (tmp.val() > -1) {
                        tmp.html('<option value="-1" data-id="-1">Без договора</option>');
                        tmp.val(-1);

                        getItems();
                    }
                }
            });

            $('#act-revise-new-record form').find('select[name="shop_contract_id"], input[name="date_from"], input[name="date_to"]').change(function () {
                getItems();
            });
        });
    </script>
</div>