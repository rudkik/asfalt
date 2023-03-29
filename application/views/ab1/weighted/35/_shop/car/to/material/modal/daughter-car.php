<div id="dialog-daughter-car" class="modal" data-test="<?php echo floatval($data->additionDatas['is_test']); ?>">
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
                                <label>Вес</label>
                                <input data-type="money" data-fractional-length="3" class="form-control" name="quantity" placeholder="Вес" type="phone" value="<?php echo $data->values['quantity_daughter']; ?>" readonly>
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
                <button type="button" class="btn btn-primary pull-right" onclick="sendDaughterCar()">Зафиксировать</button>
            </div>
        </div>
    </div>
    <script>
        function sendDaughterCar() {
            var formData = $('#dialog-daughter-car form').serialize();

            jQuery.ajax({
                url: '/weighted/shopcartomaterial/save',
                data: formData,
                type: "POST",
                success: function (data) {
                    $('#dialog-daughter-car').modal('hide');

                    var obj = jQuery.parseJSON($.trim(data));
                    if(obj.error == 0){
                        window.location.reload();
                    }else{
                        alert(obj.msg);
                    }
                },
                error: function (data) {
                    $('#dialog-daughter-car').modal('hide');

                    console.log(data.responseText);
                }
            });
        }

        function _initDialogDaughterCar() {
            __init();
            $('#dialog-daughter-car [name="shop_subdivision_receiver_id"]').change(function () {
                var subdivision = $(this).val();
                jQuery.ajax({
                    url: '/weighted/shopheap/select_options',
                    data: ({
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                       var el = $('#dialog-daughter-car [name="shop_heap_receiver_id"]');

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