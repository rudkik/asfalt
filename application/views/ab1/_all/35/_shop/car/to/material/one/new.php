<?php $isWeighted = Request_RequestParams::getParamBoolean('is_weighted'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Отправитель
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_daughter_id" name="shop_daughter_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/daughter/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label style="margin-top: 33px;">
            Отправитель филиал
        </label>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Отправитель филиал</label>
                    <select id="shop_branch_daughter_id" name="shop_branch_daughter_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Подразделение</label>
                    <select id="shop_subdivision_daughter_id" name="shop_subdivision_daughter_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Место вывоза</label>
                    <select id="shop_heap_daughter_id" name="shop_heap_daughter_id" class="form-control select2" style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label style="margin-top: 33px;">
            Получатель филиал
        </label>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Получатель филиал</label>
                    <select id="shop_branch_receiver_id" name="shop_branch_receiver_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Подразделение</label>
                    <select id="shop_subdivision_receiver_id" name="shop_subdivision_receiver_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Место завоза</label>
                    <select id="shop_heap_receiver_id" name="shop_heap_receiver_id" class="form-control select2" style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Материал
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_material_id" name="shop_material_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
        </select>
    </div>
</div>
<?php if($isWeighted){?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Владелец транспорта
            </label>
        </div>
        <div class="col-md-9">
            <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
            </select>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                № автомобиля
            </label>
        </div>
        <div class="col-md-3">
            <select id="shop_car_tare_id" name="shop_car_tare_id" class="text-number form-control select2" style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php
                $name = 'data-name="'.Request_RequestParams::getParamStr('number').'"';
                echo str_replace($name, $name.' selected', $siteData->replaceDatas['view::_shop/car/tare/list/list']);
                ?>
            </select>
        </div>
        <div class="col-md-3 record-title">
            <label>
                ФИО водителя
            </label>
        </div>
        <div class="col-md-3">
            <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя">
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Брутто
            </label>
        </div>
        <div class="col-md-3">
            <input id="brutto" name="brutto" type="text" class="text-number form-control" required placeholder="Брутто" value="<?php echo Request_RequestParams::getParamFloat('weight'); ?>"  readonly>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Нетто
            </label>
        </div>
        <div class="col-md-3">
            <input id="netto" type="text" class="text-number form-control" required placeholder="Нетто" readonly>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Вес по накладной (сторонная организация)
            </label>
        </div>
        <div class="col-md-9">
            <input data-type="money" data-fractional-length="3" id="quantity_invoice" name="quantity_invoice" type="text" class="form-control" required placeholder="Вес по накладной (сторонная организация)">
        </div>
    </div>
<?php }else{?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Вес (т)
            </label>
        </div>
        <div class="col-md-3">
            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="text-number form-control" required>
        </div>
    </div>
<?php }?>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1">
        <input id="is_weighted" name="is_weighted" value="<?php echo floatval(Request_RequestParams::getParamBoolean('is_weighted')); ?>">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCar('shopcartomaterial');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="submitCar('shopcartomaterial');">Сохранить</button>
    </div>
</div>
<script>
    function submitCar(id) {
        var isError = false;

        var element = $('[name="shop_material_id"]');
        if (Number($.trim(element.val())) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        <?php if($isWeighted){?>
            var element = $('[name="shop_car_tare_id"]');
            if (Number($.trim(element.val())) < 1){
                element.parent().addClass('has-error');
                isError = true;
            }else{
                element.parent().removeClass('has-error');
            }

            var element = $('[name="brutto"]');
            if(element !== undefined) {
                var str = element.val();
                if ((str !== undefined) && (!$.isNumeric(str) || Number(str) <= 0.001)){
                    element.parent().addClass('has-error');
                    isError = true;
                } else {
                    element.parent().removeClass('has-error');
                }
            }
        <?php }else{?>
            var element = $('[name="quantity"]');
            if(element !== undefined) {
                var str = element.valNumber();
                if ((str !== undefined) && (!$.isNumeric(str) || Number(str) <= 0.001)){
                    element.parent().addClass('has-error');
                    isError = true;
                } else {
                    element.parent().removeClass('has-error');
                }
            }
        <?php }?>

        if(!isError) {
            $('#'+id).submit();
        }
    }

    $(document).ready(function () {
        $('#shop_branch_receiver_id').change(function () {
            var shop = $(this).val();
            if (shop > 0){
                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopsubdivision/select_options',
                    data: ({
                        'shop_branch_id': (shop)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_subdivision_receiver_id').select2('destroy').empty().html(data).select2().val(-1);
                        $('#shop_heap_receiver_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

            }else{
                $('#shop_subdivision_receiver_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
                $('#shop_heap_receiver_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
            }
        });
        $('#shop_subdivision_receiver_id').change(function () {
            var shop = $('#shop_branch_receiver_id').val();
            var subdivision = $(this).val();
            if (shop > 0){
                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopheap/select_options',
                    data: ({
                        'shop_branch_id': (shop),
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_heap_receiver_id').select2('destroy').empty().html(data).select2()
                            .val(0).trigger('change');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

            }else{
                $('#shop_heap_receiver_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
            }
        });

        $('#shop_branch_daughter_id').change(function () {
            var shop = $(this).val();
            if (shop > 0){
                $('#shop_daughter_id').val(0).trigger('change');
                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopsubdivision/select_options',
                    data: ({
                        'shop_branch_id': (shop)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_subdivision_daughter_id').select2('destroy').empty().html(data).select2().val(-1);
                        $('#shop_heap_daughter_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2()
                            .val($('#shop_heap_daughter_id').find(':first').attr('value'));
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }else{
                $('#shop_subdivision_daughter_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
                $('#shop_heap_daughter_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
            }
        });
        $('#shop_subdivision_daughter_id').change(function () {
            var shop = $('#shop_branch_daughter_id').val();
            var subdivision = $(this).val();
            if (shop > 0){
                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopheap/select_options',
                    data: ({
                        'shop_branch_id': (shop),
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_heap_daughter_id').select2('destroy').empty().html(data).select2()
                            .val($('#shop_heap_daughter_id').find(':eq(1)').attr('value')).trigger('change');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }else{
                $('#shop_heap_daughter_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
            }
        });

        $('#shop_daughter_id').change(function () {
            var shop = $(this).val();
            if (shop > 0){
                $('#shop_branch_daughter_id').val(0).trigger('change');
                $('#shop_subdivision_daughter_id').val(0).trigger('change');
                $('#shop_heap_daughter_id').val(0).trigger('change');
            }
        });
    });
</script>