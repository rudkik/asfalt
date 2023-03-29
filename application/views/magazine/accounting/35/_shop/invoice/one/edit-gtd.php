<div class="inline-block">
    <h3 class="pull-left">Счет-фактура / ЭСФ <small style="margin-right: 10px;">редактирование</small></h3>
    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array('id' => 'id'));?>" class="btn bg-blue btn-flat pull-left margin-l-10">
        Накладная
    </a>
    <?php if($data->values['is_import_esf'] == 0){?>
        <button type="button" class="btn bg-orange btn-flat pull-right margin-l-10" onclick="submitinvoice('shopinvoice');">Сохранить</button>
    <?php } ?>
    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/save_new', array('id' => 'id'), array('is_esf' => true, 'url' => '/accounting/shopinvoice/edit_gtd?id='.$data->id));?>" class="btn bg-blue btn-flat pull-right margin-l-10">
        Пересчитать ЭСФ
    </a>
    <a href="<?php echo Func::getFullURL($siteData, '/shopxml/save_invoice_esf', array('id' => 'id'));?>" class="btn bg-purple btn-flat pull-right margin-l-10">
        <i class="fa fa-fw fa-download"></i>
        Экспортировать
    </a>
    <button type="button" class="btn bg-purple btn-flat pull-right margin-l-10" data-toggle="modal" data-target="#dialog-import">
        <i class="fa fa-fw fa-upload"></i>
        Импортировать
    </button>
</div>
<form id="shopinvoice" action="<?php echo Func::getFullURL($siteData, '/shopinvoice/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    Номер
                </label>
                <input name="number" type="text" class="form-control" placeholder="Номер" value="<?php echo $data->values['number']; ?>" <?php if($data->values['is_import_esf'] == 1){?>readonly<?php }?>>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    Номер ЭСФ
                </label>
                <input name="number_esf" type="text" class="form-control" placeholder="Номер ЭСФ" value="<?php echo $data->values['number_esf']; ?>" <?php if($data->values['is_import_esf'] == 1){?>readonly<?php }?>>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    Вид ЭСФ
                </label>
                <select data-type="select2" name="esf_type_id" class="form-control select2" required style="width: 100%;" disabled>
                    <option value="<?php echo Model_Magazine_ESFType::ESF_TYPE_ELECTRONIC; ?>">Основная</option>
                    <option value="<?php echo Model_Magazine_ESFType::ESF_TYPE_RETURN; ?>" <?php if($data->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_RETURN){echo 'selected';} ?>>Возвратная</option>
                    <option value="<?php echo Model_Magazine_ESFType::ESF_TYPE_CORRECT; ?>" <?php if($data->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_CORRECT){echo 'selected';} ?>>Исправленная</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Дата совершения оборота
                </label>
                <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" <?php if($data->values['is_import_esf'] == 1){?>readonly<?php }?>>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Дата выписки
                </label>
                <input name="esf_date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['esf_date']); ?>" <?php if($data->values['is_import_esf'] == 1){?>readonly<?php }?>>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Период реализации от
                </label>
                <input name="date_from" type="text" class="form-control" value="<?php $tmp = Request_RequestParams::getParamDate('date_from'); if($tmp !== NULL){echo Helpers_DateTime::getDateFormatRus($tmp);}else{echo Helpers_DateTime::getDateFormatRus($data->values['date_from']);} ?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Период реализации до
                </label>
                <input name="date_to" type="text" class="form-control" value="<?php $tmp = Request_RequestParams::getParamDate('date_to'); if($tmp !== NULL){echo Helpers_DateTime::getDateFormatRus($tmp);}else{echo Helpers_DateTime::getDateFormatRus($data->values['date_to']);} ?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Кол-во
                </label>
                <input type="text"  class="form-control text-right" value="<?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, false); ?>" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    Сумма
                </label>
                <input type="text"  class="form-control text-right" value="<?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, false); ?>" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 box-body-goods padding-r-0">
            <table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
                <tr class="bg-light-blue-active">
                    <th class="width-75">Приемка</th>
                    <th class="width-30 text-right">№</th>
                    <th>Продукция</th>
                    <th class="width-120 text-center">Признак происхождения</th>
                    <th class="width-145 text-center">№ декларации</th>
                    <th class="width-125 text-center">Номер товарной позиции</th>
                    <th class="width-125 text-center">Идентификатор ГСВС</th>
                    <th class="width-125">Ед. измерения</th>
                    <th class="width-100 text-right">Кол-во</th>
                    <th class="width-100 text-right">Цена</th>
                    <th class="width-100 text-right">Сумма</th>
                </tr>
                <tbody id="products">
                <?php echo $siteData->globalDatas['view::_shop/invoice/item/gtd/list/invoice'];?>
                <tr>
                    <td colspan="6" class="bg-light-blue-active b-green text-right">Итого</td>
                    <td class="bg-light-blue-active b-green text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
                    <td class="bg-light-blue-active b-green text-right">x</td>
                    <td class="bg-light-blue-active b-green text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
                </tr>
                </tbody>
            </table>
            <style>
                .icheckbox_minimal-blue.checked.disabled {
                    background-position: -40px 0 !important;
                }
            </style>
            <script>
                $('[data-action="edit-gtd-items"]').on('change', function(){
                    jQuery.ajax({
                        url: '/accounting/shopinvoice/save_item_gtd_tru_origin_code',
                        data: ({
                            shop_invoice_id: (<?php echo Request_RequestParams::getParamInt('id'); ?>),
                            price_realization: ($(this).data('price_realization')),
                            shop_production_id: ($(this).data('shop_production_id')),
                            tru_origin_code: ($(this).data('tru_origin_code')),
                            product_declaration: ($(this).data('product_declaration')),
                            product_number_in_declaration: ($(this).data('product_number_in_declaration')),
                            is_esf: ($(this).data('is_esf')),
                            new_tru_origin_code: ($(this).val()),
                        }),
                        type: "POST",
                        success: function (data) {
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                });
            </script>
        </div>
    </div>
    <div class="row">
        <div hidden>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1">
        </div>
    </div>
</form>
<script>
    function submitinvoice(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>
<div id="dialog-import" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Импорт файла ЭСФ</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopinvoice/import_esf'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            Файл
                        </label>
                        <div class="file-upload" data-text="Выберите файл">
                            <input type="file" name="file" multiple>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('[data-action="save-invoice-price"]').on('change', function(){
        var price = Number($(this).val().replace(/[^0-9,\.]/gim,''));
        var quantity = Number($(this).data('quantity'));
        $(this).closest('tr').find('[data-id="amount"]').text(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(price * quantity).replace(',', '.'))
        jQuery.ajax({
            url: '/accounting/shopinvoice/save_item_price',
            data: ({
                shop_invoice_id: (<?php echo Request_RequestParams::getParamInt('id');?>),
                shop_invoice_item_id: ($(this).data('shop_invoice_item_id')),
                shop_production_id: ($(this).data('shop_production_id')),
                shop_product_id: ($(this).data('shop_product_id')),
                price: (price),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(!obj.error){
                    var name = obj.values.name;
                    if(obj.values.bin != ''){
                        name = name+' - '+obj.values.bin;
                    }

                    supplier = $('#shop_supplier_id');
                    supplier.data('amount', 0);
                    supplier.val(obj.values.id);
                    supplier.attr('value', obj.values.id).trigger("change");
                    $('#shop_supplier_name').val(obj.values.name + ' - '+obj.values.bin);
                    $('#shop_supplier_name').attr('value', obj.values.name + ' - '+obj.values.bin);
                    $('#dialog-supplier').modal('hide');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
</script>