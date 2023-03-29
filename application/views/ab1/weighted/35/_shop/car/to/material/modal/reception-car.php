<div id="dialog-reception-car" class="modal" data-test="<?php echo floatval($data->additionDatas['is_test']); ?>">
    <div class="modal-dialog" style="max-width: 600px; width: 100%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Принять машину</h4>
            </div>
            <form class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Номер машины</label>
                                <input class="form-control text-number" name="name" data-type="auto-number" placeholder="Номер машины" type="text" value="<?php echo $data->values['name']; ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Брутто</label>
                                <input class="form-control" name="brutto" placeholder="Брутто" type="text" value="<?php echo $data->additionDatas['brutto']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Тара</label>
                                <input class="form-control" name="tarra" placeholder="Тара" type="text" value="<?php echo $data->values['tarra']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Нетто</label>
                                <input class="form-control text-number" name="netto" placeholder="Нетто" type="text" value="<?php echo $data->additionDatas['brutto'] - $data->values['tarra'] ; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Материал</label>
                                <select id="shop_material_id" name="shop_material_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Подразделение</label>
                                <select id="shop_subdivision_receiver_id" name="shop_subdivision_receiver_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/subdivision/receiver/list/list']); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Место завоза</label>
                                <select id="shop_heap_receiver_id" name="shop_heap_receiver_id" class="form-control select2" style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/heap/receiver/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input name="id" value="<?php echo $data->values['id']; ?>" style="display: none">
                    <input name="is_test" value="<?php echo floatval($data->additionDatas['is_test']); ?>" style="display: none">
                    <input name="json" value="1" style="display: none">
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary pull-right" onclick="sendReceptionCar()">Зафиксировать</button>
            </div>
        </div>
    </div>
    <script>
        function sendReceptionCar() {
            var formData = $('#dialog-reception-car form').serialize();

            jQuery.ajax({
                url: '/weighted/shopcartomaterial/save',
                data: formData,
                type: "POST",
                success: function (data) {
                    $('#dialog-reception-car').modal('hide');

                    var obj = jQuery.parseJSON($.trim(data));
                    if(obj.error == 0){
                        window.location.reload();
                    }else{
                        alert(obj.msg);
                    }
                },
                error: function (data) {
                    $('#dialog-reception-car').modal('hide');

                    console.log(data.responseText);
                }
            });
        }

        function _initDialogReceptionCar() {
            __init();
            $('#dialog-reception-car [name="shop_subdivision_receiver_id"]').change(function () {
                var subdivision = $(this).val();
                jQuery.ajax({
                    url: '/weighted/shopheap/select_options',
                    data: ({
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                        var el = $('#dialog-reception-car [name="shop_heap_receiver_id"]');

                        el.select2('destroy').empty().html(data).select2()
                            .val(el.find(':eq(1)').attr('value')).trigger('change');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });
        }
    </script>
</div>