<div class="row">
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дата
                </label>
            </div>
            <div class="col-md-9">
                <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Клиент
                </label>
            </div>
            <div class="col-md-9">
                <select data-client="<?php echo $data->values['shop_client_id'];?>" data-action="shop_client" data-basic-url="sales" data-action-select2="1"
                        id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%"
                        data-is-invoice-print="<?php echo Func::boolToStr(Func::_empty($data->getElementValue('shop_client_id', 'bin'))); ?>" data-less-zero="false">
                    <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Филиал
                </label>
            </div>
            <div class="col-md-9">
                <select disabled id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Объект
                </label>
            </div>
            <div class="col-md-9">
                <input name="facility" type="text" class="form-control" placeholder="Объект" value="<?php echo htmlspecialchars($data->values['facility'], ENT_QUOTES); ?>">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Время начало
                </label>
            </div>
            <div class="col-md-9">
                <input name="time_from" type="datetime" date-type="time" class="form-control" value="<?php echo Helpers_DateTime::getTimeByDate($data->values['date_from']); ?>">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Время окончания
                </label>
            </div>
            <div class="col-md-9">
                <input name="time_to" type="datetime" date-type="time" class="form-control" value="<?php echo Helpers_DateTime::getTimeByDate($data->values['date_to']); ?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Кол-во машин
                </label>
            </div>
            <div class="col-md-9">
                <input data-type="money" data-fractional-length="0" name="car_count" type="text" class="form-control" placeholder="Кол-во машин" value="<?php echo htmlspecialchars($data->values['car_count'], ENT_QUOTES); ?>">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Машины
                </label>
            </div>
            <div class="col-md-9">
                <table class="table table-hover table-db table-tr-line" >
                    <tr>
                        <th>Номера машин</th>
                        <th style="width: 85px;"></th>
                    </tr>
                    <tbody id="cars">
                    <?php foreach ($data->values['cars'] as $key => $number){?>
                        <tr>
                            <td>
                                <input name="cars[s<?php echo $key; ?>]" type="text" data-type="auto-number" class="form-control" placeholder="№ авто" value="<?php echo $number; ?>">
                            </td>
                            <td>
                                <ul class="list-inline tr-button delete">
                                    <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-car', 'cars', true);">Добавить машину</button>
                </div>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Доставка
                </label>
            </div>
            <div class="col-md-9">
                <table class="table table-hover table-db table-tr-line" >
                    <tr>
                        <th style="width: 50%">Машина</th>
                        <th style="width: 50%">Кол-во</th>
                        <th style="min-width: 85px;"></th>
                    </tr>
                    <tbody id="deliveries">
                    <?php $i = 0; foreach ($data->values['deliveries'] as $key => $transport){ $i++;?>
                        <tr>
                            <td>
                                <select name="deliveries[s<?php echo $i; ?>][shop_special_transport_id]" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php
                                    $s = 'data-id="'.Arr::path($transport, 'shop_special_transport_id', 0).'"';
                                    echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/special/transport/list/list']);
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input name="deliveries[s<?php echo $i; ?>][count]" type="text" class="form-control" placeholder="Кол-во" value="<?php echo Arr::path($transport, 'count', 0); ?>">
                            </td>
                            <td>
                                <ul class="list-inline tr-button delete">
                                    <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-delivery', 'deliveries', true);">Добавить машину</button>
                </div>
            </div>
        </div>


        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Ответственное лицо (прораб)
                </label>
            </div>
            <div class="col-md-9">
                <select id="shop_client_foreman_id" name="shop_client_foreman_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php // echo $siteData->globalDatas['view::_shop/client/foreman/list/list']; ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div id="new-car" data-index="0">
    <!--
    <tr>
        <td>
            <input name="cars[_#index#]" type="text" data-type="auto-number" class="form-control" placeholder="№ авто" required value="">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div id="new-delivery" data-index="0">
    <!--
    <tr>
        <td>
            <select name="deliveries[_#index#][shop_special_transport_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/special/transport/list/list']; ?>
            </select>
        </td>
        <td>
            <input name="deliveries[_#index#][count]" type="text"  class="form-control" placeholder="Кол-во" required value="">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Продукция
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/plan/item/list/index'];?>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    $(function () {
        $('#shop_branch_id').change(function () {
            var id = $(this).val();

            var url = '/sales/shopproduct/select_options';
            jQuery.ajax({
                url: url,
                data: ({
                    'shop_branch_id': (id),
                }),
                type: "POST",
                success: function (data) {
                    $('#shop_product_id').select2('destroy').empty().html(data).select2().val(-1);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });


            var url = '/sales/shopturnplace/select_options';
            jQuery.ajax({
                url: url,
                data: ({
                    'shop_branch_id': (id),
                }),
                type: "POST",
                success: function (data) {
                    $('#shop_turn_place_id').select2('destroy').empty().html(data).select2().val(-1);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
    });
</script>