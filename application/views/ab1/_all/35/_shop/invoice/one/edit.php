<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-12">
        <h3 class="pull-left">Накладная <small style="margin-right: 10px;">редактирование</small></h3>
        <div class="box-bth-right">
            <?php if($data->values['is_give_to_client'] == 1){?>
                <span class="pull-left" style="margin-top: 7px;" <?php $list = Arr::path($data->values['options'], 'date_give_to_clients', array()); if(count($list) > 0){ ?> data-action="tooltip" data-original-title="<?php
                $s = '';
                foreach ($list as $one){
                    $s .= Helpers_DateTime::getDateTimeFormatRus($one) . '<br>';
                }
                echo $s;
                ?>" data-html="true"
                <?php } ?>>Выдано клиенту: <b><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_give_to_client']);?></b></span>
            <?php }?>
            <?php if(!$isShow){ ?>
                <?php if(false && $data->values['check_type_id'] == Model_Ab1_CheckType::CHECK_TYPE_PRINT){?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/client_invoice', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-blue btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> Выдать накладную клиенту</a>
                <?php } ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/invoice_one', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-navy btn-flat pull-left"><i class="fa fa-fw fa-list-alt"></i> Накладная</a>
                <?php if(($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_SBYT || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING) && ($data->values['check_type_id'] != Model_Ab1_CheckType::CHECK_TYPE_PRINT || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING || $siteData->operation->getIsAdmin())){?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/calc_invoice_price', array(), array('shop_invoice_id' => $data->values['id']), $data->values, false, false, true); ?>" data-toggle="modal" class="btn bg-purple btn-flat pull-left">
                        <i class="fa fa-calculator margin-r-5"></i>
                        Пересчитать цены
                    </a>
                <?php } ?>
                <?php if(Request_RequestParams::getParamBoolean('is_all')){?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array(), array('id' => $data->values['id']), $data->values, false, false, true); ?>" class="btn bg-green btn-flat pull-left"><i class="fa fa-fw fa-minus"></i> Сокращено</a>
                <?php }else{?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array(), array('id' => $data->values['id'], 'is_all' => '1'), $data->values, false, false, true); ?>" class="btn bg-green btn-flat pull-left"><i class="fa fa-fw fa-plus"></i> Подробно</a>
                <?php }?>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Номер
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" placeholder="Номер" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES);?>" disabled>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дата
                </label>
            </div>
            <div class="col-md-9">
                <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']);?>" <?php if($isShow){ ?>readonly<?php } ?>>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Клиент
                </label>
            </div>
            <?php
            $amount = $data->getElementValue('shop_client_id', 'balance_cache');
            if ($amount < 0){
                $amount = 0;
            }
            ?>
            <div class="col-md-9">
                <select data-client="<?php echo $data->values['shop_client_id'];?>" data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                        data-attorney="#shop_client_attorney_id" data-contract="#shop_client_contract_id"
                        id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%"
                        data-cache="<?php echo $amount; ?>" <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
            </div>
            <div class="col-md-9">
                <label class="span-checkbox">
                    <input <?php if ($data->values['is_delivery'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
                    С доставкой
                </label>
                <style>
                    .icheckbox_minimal-blue.disabled.checked {
                        background-position: -40px 0 !important;
                    }
                </style>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>Доверенность</label>
            </div>
            <div class="col-md-9">
                <select data-date="<?php echo $data->values['date']; ?>"  data-client="<?php echo $data->values['shop_client_id'];?>" data-contract="#shop_client_contract_id" data-product="#shop_product_id" id="shop_client_attorney_id" name="shop_client_attorney_id"
                        data-amount="<?php echo $data->getElementValue('shop_client_attorney_id', 'balance', $data->getElementValue('shop_client_id', 'balance_cache', 0)); ?>"
                        data-branch-id="<?php echo $data->values['shop_id']; ?>" data-attorney-id="<?php echo $data->values['shop_client_attorney_id']; ?>"
                        class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="0" data-id="0">Наличными</option>
                    <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/option']; ?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>Договор</label>
            </div>
            <div class="col-md-9">
                <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="<?php echo $data->values['shop_client_contract_id']; ?>" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="0" data-id="0">Без договора</option>
                    <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <h4 class="text-blue">
            <span>Балансы на <?php echo date('d.m.Y H:s');?></span>
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/calc_balance', array(), array('id' =>  $data->values['shop_client_id'], 'url' => '/general/shopinvoice/edit'.URL::query())); ?>" style="margin-left: 15px;font-size: 16px;" class="link-green"><i class="fa fa-calculator margin-r-5"></i> Пересчитать баланс</a>
        </h4>
        <?php echo trim($siteData->globalDatas['view::_shop/client/one/invoice-balance']); ?>
        <?php echo trim($siteData->globalDatas['view::_shop/client/attorney/list/invoice']); ?>
    </div>
    <div class="col-md-6">
        <h4 class="text-blue">
            <span>Итоги на <?php echo Helpers_DateTime::getDateTimeFormatRus(Helpers_DateTime::plusDays($data->values['date'].' 06:00:00', 1));?></span>
        </h4>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Договор</label>
                    <input type="text" class="form-control" value="<?php echo Func::getNumberStr($data->additionDatas['balance_contract'], true, 2, false);?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Доверенность</label>
                    <input type="text" class="form-control" value="<?php echo Func::getNumberStr($data->additionDatas['balance_attorney'], true, 2, false);?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Наличные</label>
                    <input type="text" class="form-control" value="<?php echo Func::getNumberStr($data->additionDatas['balance_cash'], true, 2, false);?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Общий баланс</label>
                    <input type="text" class="form-control" value="<?php echo Func::getNumberStr($data->additionDatas['balance'], true, 2, false);?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!$isShow && ($data->values['check_type_id'] != Model_Ab1_CheckType::CHECK_TYPE_PRINT || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING || $siteData->operation->getIsAdmin())){ ?>
    <div class="row">
        <div hidden>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <input name="shop_branch_id" value="<?php echo Arr::path($data->values, 'shop_id', 0);?>">
            <input name="check_type_id" value="<?php echo Arr::path($data->values, 'check_type_id', 0);?>">
        </div>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-primary pull-right margin-l-10" onclick="submitInvoice('shopinvoice');">Сохранить</button>
            <?php if($data->values['check_type_id'] != Model_Ab1_CheckType::CHECK_TYPE_PRINT){ ?>
                <button type="button" class="btn bg-green pull-right" onclick="submitInvoicePrint('shopinvoice');">Разрешено к печати</button>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Продукция
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/invoice/item/list/index'];?>
    </div>
</div>
<script>
    $(function () {
        $('[data-action="invoice-edit"]').click(function () {
            var url = $(this).attr('href');
            jQuery.ajax({
                url: url,
                data: ({}),
                type: "POST",
                success: function (data) {
                    var form = $('#dialog-invoice-edit')
                    form.modal('hide');
                    form.remove();

                    $('body').append(data);

                    __init();
                    $('#dialog-invoice-edit').modal('show');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
    });

    function submitInvoiceCheck(id) {
        $('[name="check_type_id"]').val(<?php echo Model_Ab1_CheckType::CHECK_TYPE_CHECK; ?>).attr('value', <?php echo Model_Ab1_CheckType::CHECK_TYPE_CHECK; ?>);
        submitInvoice(id);
    }

    function submitInvoicePrint(id) {
        $('[name="check_type_id"]').val(<?php echo Model_Ab1_CheckType::CHECK_TYPE_PRINT; ?>).attr('value', <?php echo Model_Ab1_CheckType::CHECK_TYPE_PRINT; ?>);
        submitInvoice(id);
    }

    function submitInvoice(id) {
        var isError = false;

        var element = $('[name="shop_client_id"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="date"]');
        if ($.trim(element.val()) == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>