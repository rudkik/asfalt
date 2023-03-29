<?php
$clientContractTypeID = Request_RequestParams::getParamInt('client_contract_type_id');
$clientContractStatusID = Request_RequestParams::getParamInt('client_contract_status_id');
$clientContractKindID = Request_RequestParams::getParamInt('client_contract_kind_id');
$subject = Request_RequestParams::getParamStr('subject');
?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_show_branch" value="0" type="checkbox" class="minimal">
            Показывать договор филиалам
        </label>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3" <?php if($clientContractTypeID > 0 && $clientContractTypeID < 101){ ?>style="display: none"<?php }?>>
        <label class="span-checkbox">
            <input name="is_receive" <?php if (Request_RequestParams::getParamBoolean('is_receive')) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>  type="checkbox" class="minimal">
            Покупатель
        </label>
        <span class="link-muted">(договор на продажу клиенту)</span>
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
        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_prolongation" value="0" style="display: none;">
            <input name="is_prolongation" value="0" type="checkbox" class="minimal">
            Предусмотрена ли пролонгация?
        </label>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_redaction_client" value="0" style="display: none;">
            <input name="is_redaction_client" value="0" type="checkbox" class="minimal">
            Редакция клиента
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Номер договора
        </label>
    </div>
    <div class="col-md-3">
        <input id="number" name="number" type="text" class="form-control" placeholder="Номер договора">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Основной договор
        </label>
    </div>
    <div class="col-md-3">
        <select data-basic-url="<?php echo $siteData->actionURLName;?>"
                id="basic_shop_client_contract_id" name="basic_shop_client_contract_id" class="form-control select2" style="width: 100%">
        </select>
    </div>
</div>
<?php if($clientContractKindID > 0){ ?>
    <input name="client_contract_kind_id" value="<?php echo $clientContractKindID; ?>" style="display: none">
<?php }else{ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Вид взаимоотношений
            </label>
        </div>
        <div class="col-md-3">
            <select id="client_contract_kind_id" name="client_contract_kind_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::client-contract/kind/list/list'];?>
            </select>
        </div>
    </div>
<?php } ?>
<div class="row record-input record-list">
    <?php if($clientContractTypeID > 0){ ?>
        <input name="client_contract_type_id" value="<?php echo $clientContractTypeID; ?>" style="display: none">
    <?php }else{ ?>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Категория договора
            </label>
        </div>
        <div class="col-md-3">
            <select id="client_contract_type_id" name="client_contract_type_id" class="form-control select2" style="width: 100%" required>
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::client-contract/type/list/list'];?>
            </select>
        </div>
    <?php } ?>
    <?php if($clientContractStatusID == 0){ ?>
        <div class="col-md-3 record-title">
            <label>
                Статус договора
            </label>
        </div>
        <div class="col-md-3">
            <select id="client_contract_status_id" name="client_contract_status_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::client-contract/status/list/list'];?>
            </select>
        </div>
    <?php } ?>
</div>
<?php if($clientContractTypeID < 1){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Тип договора
            </label>
        </div>
        <div class="col-md-3">
            <select id="client_contract_view_id" name="client_contract_view_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::client-contract/view/list/list'];?>
            </select>
        </div>
        <div class="col-md-3 record-title">
            <label>
                Исполнитель
            </label>
        </div>
        <div class="col-md-3">
            <select id="executor_shop_worker_id" name="executor_shop_worker_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/worker/list/list'];?>
            </select>
        </div>
    </div>
<?php } ?>
<?php if(!empty($subject)){ ?>
    <textarea name="subject" style="display: none;"><?php echo htmlspecialchars($subject, ENT_QUOTES); ?></textarea>
<?php }elseif($clientContractTypeID != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Предмет договора
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="subject" class="form-control" rows="1" placeholder="Предмет договора"></textarea>
        </div>
    </div>
<?php } ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Общая сумма договора
        </label>
    </div>
    <div class="col-md-3">
        <?php if($clientContractTypeID < 1
            || $clientContractTypeID == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW
            || $clientContractTypeID == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL){ ?>
            <div class="row">
                <div class="col-md-6">
                    <input data-type="money" data-fractional-length="2" id="amount_total" name="amount" type="text" class="form-control" placeholder="Общая сумма договора">
                </div>
                <div class="col-md-6">
                    <select id="currency_id" name="currency_id" class="form-control select2" style="width: 100%">
                        <?php echo $siteData->globalDatas['view::currency/list/list'];?>
                    </select>
                </div>
            </div>
        <?php }else{?>
            <input data-type="money" data-fractional-length="2" id="amount_total" name="amount" type="text" class="form-control" placeholder="Общая сумма договора">
        <?php }?>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Начало договора
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime" date-type="date" class="form-control">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Окончание договора
        </label>
    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-6">
                <input name="to_at" type="datetime" date-type="date" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="span-checkbox">
                    <input name="is_perpetual" value="0" style="display: none;">
                    <input name="is_perpetual" value="0" type="checkbox" class="minimal">
                    До исполнения обязательства
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <?php if($siteData->operation->getIsAdmin() || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_JURIST){ ?>
        <div class="col-md-3 record-title">
            <label>
                № регистра
            </label>
        </div>
        <div class="col-md-3">
            <select id="shop_client_contract_storage_id" name="shop_client_contract_storage_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/client/contract/storage/list/list'];?>
            </select>
        </div>
    <?php } ?>
    <?php if($siteData->operation->getShopTableRubricID() != Model_Ab1_Shop_Operation::RUBRIC_SBYT){ ?>
        <div class="col-md-3 record-title">
            <label>
                Отдел
            </label>
        </div>
        <div class="col-md-3">
            <select id="shop_department_id" name="shop_department_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/department/list/list'];?>
            </select>
        </div>
    <?php } ?>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_add_basic_contract" value="0" type="checkbox" class="minimal">
            Сумму товаров плюсовать к основному договору?
        </label>
        <span class="link-muted">(влияет на итоговую сумму основного договора)</span>
    </div>
</div>
<div class="row" style="margin-top: 30px">
    <div class="col-md-12">
        <h3>
            Товары договора
        </h3>
    </div>
    <div id="contract-items" class="col-md-12" style="overflow-x: auto">
        <?php echo $siteData->globalDatas['view::_shop/client/contract/item/list/item'];?>
    </div>
</div>
<div class="row">
    <input id="is_close" name="is_close" value="1" style="display: none">
    <div class="modal-footer text-center">
        <button type="button" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="button" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#shop_client_id').change(function () {
            var basicURL = $(this).data('basic-url');
            var client = $(this).val();
            loadBasicContract(client, $('#basic_shop_client_contract_id'), basicURL);
        });

        $('#client_contract_type_id').change(function () {
            var clientContractTypeID = $(this).val();
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName;?>/shopclientcontract/items',
                data: ({
                    'client_contract_type_id': (clientContractTypeID),
                    'id': (<?php echo $data->id;?>),
                }),
                type: "POST",
                success: function (data) {
                    $('#contract-items').html(data);
                    _initCalc($('#contract-items').find('input[data-id="quantity"], input[data-id="price"]'));
                    _initDelete($('#contract-items').find('[data-action="remove-tr"]'));
                    __init();
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        $('#number, #basic_shop_client_contract_id').change(function () {
            var number = $('#number').val();
            if(number == '' || $('#basic_shop_client_contract_id').val() > 0){
                $('#number').parent().removeClass('has-error');
                return false;
            }

            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName;?>/shopclientcontract/json',
                data: ({
                    'client_contract_type_id': (-1),
                    'number_full': (number),
                    'limit': (1),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var element = $('#number');
                    if(obj.length > 0){
                        element.parent().addClass('has-error');
                        isError = true;
                    }else{
                        element.parent().removeClass('has-error');
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    });
</script>
