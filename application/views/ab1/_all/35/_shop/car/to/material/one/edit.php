<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<?php $isWeighted = $data->values['is_weighted'] == 1; ?>
<?php if($siteData->operation->getIsAdmin()){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Дата документа
            </label>
        </div>
        <div class="col-md-3">
            <input name="date_document" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_document']); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Дата создания
            </label>
        </div>
        <div class="col-md-3">
            <input name="created_at" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
    </div>
<?php } ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Отправитель
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_daughter_id" name="shop_daughter_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
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
                        <?php
                        $tmp = 'data-id="'.$data->values['shop_branch_daughter_id'].'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Подразделение</label>
                    <select id="shop_subdivision_daughter_id" name="shop_subdivision_daughter_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/subdivision/daughter/list/list']); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Место вывоза</label>
                    <select id="shop_heap_daughter_id" name="shop_heap_daughter_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/heap/daughter/list/list']); ?>
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
                        <?php
                        $tmp = 'data-id="'.$data->values['shop_branch_receiver_id'].'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Подразделение</label>
                    <select id="shop_subdivision_receiver_id" name="shop_subdivision_receiver_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/subdivision/receiver/list/list']); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Место завоза</label>
                    <select id="shop_heap_receiver_id" name="shop_heap_receiver_id" class="form-control select2" style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/heap/receiver/list/list']); ?>
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
        <select id="shop_material_id" name="shop_material_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
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
            <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
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
            <select id="shop_car_tare_id" name="shop_car_tare_id" class="form-control select2 text-number" required style="width: 100%;" <?php if(($siteData->action != 'clone') && (!$siteData->operation->getIsAdmin())) { ?> disabled<?php } ?> <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="0" data-id="0">Без значения</option>
                <?php if($siteData->action == 'clone') { ?>
                    <?php
                    $s = 'data-name="'.Request_RequestParams::getParamStr('number').'"';
                    echo str_replace($s, $s.' selected', str_replace('selected', '', $siteData->replaceDatas['view::_shop/car/tare/list/list']));
                    ?>
                <?php }else{ ?>
                    <?php echo $siteData->globalDatas['view::_shop/car/tare/list/list']; ?>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3 record-title">
            <label>
                ФИО водителя
            </label>
        </div>
        <div class="col-md-3">
            <input name="shop_driver_name" type="text" class="form-control" placeholder="ФИО водителя" value="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''), ENT_QUOTES); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
    </div>
<?php } ?>
<?php if($isWeighted){?>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label style="margin-top: 33px;">
                    Вес
                </label>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Вес (т)</label>
                            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="text-number form-control" placeholder="Вес (т)" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?>" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Вес отправителя</label>
                            <input data-type="money" data-fractional-length="3" id="quantity_daughter" name="quantity_daughter" type="text" class="text-number form-control" placeholder="Вес отправителя" value="<?php echo Func::getNumberStr($data->values['quantity_daughter'], FALSE, 3, false); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Вес по накладной (сторонная организация)</label>
                            <input data-type="money" data-fractional-length="3" id="quantity_invoice" name="quantity_invoice" type="text" class="form-control" placeholder="Вес по накладной (сторонная организация)" <?php if($siteData->action != 'clone') { ?> value="<?php echo Func::getNumberStr($data->values['quantity_invoice'], FALSE, 3, false); ?>"<?php } ?> <?php if($isShow){ ?>readonly<?php } ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <?php if($siteData->action != 'clone') { ?>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Вес
                    </label>
                </div>
                <div class="col-md-3">
                    <input data-type="money" data-fractional-length="3" id="quantity" type="text"  class="text-number form-control" placeholder="Вес" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" disabled>
                </div>
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Вес отправителя
                    </label>
                </div>
                <div class="col-md-3">
                    <input data-type="money" data-fractional-length="3" id="quantity" type="text"  class="text-number form-control" placeholder="Вес отправителя" required value="<?php echo Func::getNumberStr($data->values['quantity_daughter'], FALSE, 3, false); ?>" disabled>
                </div>
            </div>
        <?php }else{ ?>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Брутто
                    </label>
                </div>
                <div class="col-md-9">
                    <input id="brutto" name="brutto" type="text" class="text-number form-control" required placeholder="Брутто" value="<?php echo Request_RequestParams::getParamFloat('weight'); ?>"  readonly>
                </div>
            </div>
        <?php } ?>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Вес по накладной (сторонная организация)
                </label>
            </div>
            <div class="col-md-9">
                <input data-type="money" data-fractional-length="3" id="quantity_invoice" name="quantity_invoice" type="text" class="form-control" required placeholder="Вес по накладной (сторонная организация)" <?php if($siteData->action != 'clone') { ?> value="<?php echo Func::getNumberStr($data->values['quantity_invoice'], FALSE, 3, false); ?>"<?php } ?> <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
    <?php } ?>
<?php }else{?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Вес (т)
            </label>
        </div>
        <div class="col-md-3">
            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="text-number form-control" placeholder="Вес (т)" required value="<?php echo $data->values['quantity']; ?>" >
        </div>
    </div>
<?php }?>
<?php if ($data->values['is_delete']){?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Причина удаления
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="text" class="form-control" placeholder="Примечание"><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Подтверждающие файлы
            </label>
        </div>
        <div class="col-md-9">
            <input name="options[files][]" value="" style="display: none">
            <table class="table table-hover table-db table-tr-line" >
                <tr>
                    <th>Файлы</th>
                    <th class="width-90"></th>
                </tr>
                <tbody id="files">
                <?php
                $i = -1;
                foreach (Arr::path($data->values['options'], 'files', array()) as $file){
                    $i++;
                    if(empty($file)){
                        continue;
                    }
                    ?>
                    <tr>
                        <td>
                            <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>"><?php echo Arr::path($file, 'name', ''); ?></a>
                            <input name="options[files][<?php echo $i; ?>][file]" value="<?php echo Arr::path($file, 'file', ''); ?>" style="display: none">
                            <input name="options[files][<?php echo $i; ?>][name]" value="<?php echo Arr::path($file, 'name', ''); ?>" style="display: none">
                            <input name="options[files][<?php echo $i; ?>][size]" value="<?php echo Arr::path($file, 'size', ''); ?>" style="display: none">
                        </td>
                        <td>
                            <ul class="list-inline tr-button ">
                                <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                            </ul>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" onclick="addElement('new-file', 'files', true);">Добавить файл</button>
            </div>
            <div id="new-file" data-index="0">
                <!--
                <tr>
                    <td>
                        <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                            <input type="file" name="options[files][_#index#]" >
                        </div>
                    </td>
                    <td>
                        <ul class="list-inline tr-button delete">
                            <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                        </ul>
                    </td>
                </tr>
                -->
            </div>
        </div>
    </div>
<?php }?>
<div class="row">
    <?php if(!$isShow){ ?>
        <div hidden>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1">
            <input id="is_weighted" name="is_weighted" value="<?php echo $data->values['is_weighted']; ?>">
        </div>
    <?php } ?>
    <div class="modal-footer text-center">
        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/car_to_material_ttn', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-credit-card"></i> ТТН</a>
        <?php if(!$isShow){ ?>
            <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitCar('shopcartomaterial');">Применить</button>
            <button type="button" class="btn btn-primary" onclick="submitCar('shopcartomaterial');">Сохранить</button>
        <?php } ?>
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

        <?php if($data->values['is_weighted'] == 1){?>
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
                            .val($('#shop_heap_daughter_id').find(':eq(1)').attr('value')).trigger('change');
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