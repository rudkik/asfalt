<?php
$isShow = (Request_RequestParams::getParamBoolean('is_show') || $data->values['is_fixed_contract'] == 1) &&  !$siteData->operation->getIsAdmin();

$values = array(
    'contract' => $data->values,
    'client' => Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id', array()),
    'contract_root' => Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.basic_shop_client_contract_id', array()),
);
$values['contract.from_at'] = Helpers_DateTime::getDateFormatRus($data->values['from_at']);
$values['contract']['year'] = Helpers_DateTime::getYear($data->values['from_at']);
$values['contract']['from_at_rus'] = Helpers_DateTime::getDateTimeDayMonthRus($data->values['from_at'], true);
$values['contract']['amount_str'] = Func::numberToStr($data->values['amount']);
$values['contract']['amount'] = Func::getNumberStr($data->values['amount'], true, 2, false);

if(!empty($values['contract_root'])) {
    $values['contract_root.from_at'] = Helpers_DateTime::getDateFormatRus($values['contract_root']['from_at']);
    $values['contract_root']['year'] = Helpers_DateTime::getYear($values['contract_root']['from_at']);
    $values['contract_root']['from_at_rus'] = Helpers_DateTime::getDateTimeDayMonthRus($values['contract_root']['from_at'], true);
    $values['contract_root']['amount_str'] = Func::numberToStr($values['contract_root']['amount']);
    $values['contract_root']['amount_currency_str'] = Func::numberToStr($values['contract_root']['amount'], true, $siteData->currency, true, true);
    $values['contract_root']['amount'] = Func::getNumberStr($values['contract_root']['amount'], true, 2, false);
}

if($data->values['basic_shop_client_contract_id'] == 0){
    $key = 'contract';
}else{
    $key = 'agreement';
}

$tmp = $data->getElementValue('client_contract_type_id', 'options', '{}');
if(!is_array($tmp)){
    $tmp = json_decode($tmp, true);
}
$listPrint = Arr::path($tmp, $key, array());
?>
<h3>
    <?php if ($data->values['is_basic']){?>
        Договор
    <?php }else{?>
        Доп. соглашение
    <?php }?>
    <small style="margin-right: 10px;">редактирование</small>
</h3>
<form enctype="multipart/form-data" id="shopclientcontract" action="<?php echo Func::getFullURL($siteData, '/shopclientcontract/save'); ?>" method="post" style="padding-right: 5px;">
    <ul class="nav nav-tabs">
        <li class="nav-item active">
            <a class="nav-link active" data-toggle="tab" href="#description">
                <?php if ($data->values['is_basic']){?>
                    Договор
                <?php }else{?>
                    Доп. соглашение
                <?php }?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab-files">
                <?php if ($data->values['is_basic']){?>
                    Скан договора
                <?php }else{?>
                    Скан доп. соглашения
                <?php }?>
            </a>
        </li>
        <?php
        foreach ($listPrint as $key => $print){
        if(strtotime(Arr::path($print, 'date_from', '2000-01-01')) > strtotime($data->values['from_at']) || strtotime(Arr::path($print, 'date_to', '2222-01-01')) < strtotime($data->values['from_at'])){
                continue;
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#print_<?php echo $key;?>"><?php echo $print['title']; ?></a>
            </li>
        <?php } ?>
        <?php
        $fileContract = '';
        foreach (Arr::path($data->values['options'], 'files', array()) as $file){
            if(!empty($file)){
                $fileContract = Arr::path($file, 'file', '');
                break;
            }
        }
        ?>

        <?php if(!empty($fileContract)){ ?>
        <li class="pull-right header">
            <?php
            if($data->values['basic_shop_client_contract_id'] == 0){
                $id = $data->id;
            }else {
                $id = $data->values['basic_shop_client_contract_id'];
            }
            ?>
            <a target="_blank" data-action="contract-print" href="<?php echo $fileContract; ?>" class="btn bg-blue btn-flat">
                <i class="fa fa-fw fa-eye"></i>
                Просмотр основного договора
            </a>
        </li>
        <?php } ?>
        <li class="pull-right header">
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclient/edit', array(), array('id' => $data->values['shop_client_id']));?>" class="btn bg-green btn-flat">
                <i class="fa fa-fw fa-edit"></i>
                Данные клиента
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="description" style="padding-top: 20px;">
            <div class="row record-input record-list">
                <div class="col-md-3 record-title"></div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="span-checkbox">
                                <input name="is_fixed_contract" <?php if (Arr::path($data->values, 'is_fixed_contract', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){echo 'disabled';}?>>
                                Проверен?
                            </label>
                            <span class="link-muted">(после выбора, редактирование будет не возможно)</span>
                        </div>
                        <div class="col-md-6">
                            <label class="span-checkbox">
                                <input name="is_show_branch" <?php if (Arr::path($data->values, 'is_show_branch', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){echo 'disabled';}?>>
                                Показывать филиалам
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row record-input record-list" <?php if($data->values['client_contract_type_id'] > 0 && $data->values['client_contract_type_id'] < 101){ ?>style="display: none"<?php }?>>
                <div class="col-md-3 record-title"></div>
                <div class="col-md-9">
                    <label class="span-checkbox">
                        <input name="is_receive" <?php if (Arr::path($data->values, 'is_receive', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?>  type="checkbox" class="minimal">
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
                            id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%" <?php if($isShow){ ?>disabled<?php } ?>>
                        <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
                    </select>
                </div>
            </div>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title"></div>
                <div class="col-md-3">
                    <label class="span-checkbox">
                        <input name="is_prolongation" value="0" style="display: none;">
                        <input name="is_prolongation" <?php if (Arr::path($data->values, 'is_prolongation', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){echo 'readonly';}?>>
                        Предусмотрена ли пролонгация?
                    </label>
                </div>
                <div class="col-md-3 record-title"></div>
                <div class="col-md-3">
                    <label class="span-checkbox">
                        <input name="is_redaction_client" value="0" style="display: none;">
                        <input name="is_redaction_client" <?php if (Arr::path($data->values, 'is_redaction_client', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){echo 'readonly';}?>>
                        Редакция клиента
                    </label>
                </div>
            </div>
            <?php if($data->values['client_contract_type_id'] > 100 || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_JURIST){ ?>
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title">
                        <label>
                            Вид взаимоотношений
                        </label>
                    </div>
                    <div class="col-md-3">
                        <?php if($isShow){?><input name="client_contract_kind_id" value="<?php echo $data->values['client_contract_kind_id'];?>" style="display: none;"><?php }?>
                        <select id="client_contract_kind_id" name="client_contract_kind_id" class="form-control select2" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
                            <option value="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::client-contract/kind/list/list'];?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="row record-input record-list">
                <?php if($data->values['client_contract_type_id'] != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT
                        && $data->values['client_contract_type_id'] != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_FUEL){ ?>
                    <div class="col-md-3 record-title">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Категория
                        </label>
                    </div>
                    <div class="col-md-3">
                        <?php if($isShow){?><input name="client_contract_type_id" value="<?php echo $data->values['client_contract_type_id'];?>" style="display: none;"><?php }?>
                        <select id="client_contract_type_id" name="client_contract_type_id" class="form-control select2" style="width: 100%" <?php if($isShow){echo 'disabled';}?> required>
                            <option value="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::client-contract/type/list/list'];?>
                        </select>
                    </div>
                <?php } ?>
                <?php if($data->values['client_contract_type_id'] > 100 || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_JURIST){ ?>
                    <div class="col-md-3 record-title">
                        <label>
                            Статус
                        </label>
                    </div>
                    <div class="col-md-3">
                        <?php if($isShow){?><input name="client_contract_status_id" value="<?php echo $data->values['client_contract_status_id'];?>" style="display: none;"><?php }?>
                        <select id="client_contract_status_id" name="client_contract_status_id" class="form-control select2" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
                            <option value="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::client-contract/status/list/list'];?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <?php if($data->values['client_contract_type_id'] != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT){ ?>
                <div class="row record-input record-list">
                    <div class="col-md-3 record-title">
                        <label>
                            Тип
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
                        <?php if($isShow){?><input name="executor_shop_worker_id" value="<?php echo $data->values['executor_shop_worker_id'];?>" style="display: none;"><?php }?>
                        <select id="executor_shop_worker_id" name="executor_shop_worker_id" class="form-control select2" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
                            <option value="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::_shop/worker/list/list'];?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <?php if($data->values['client_contract_type_id'] != Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT){ ?>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        Предмет договора
                    </label>
                </div>
                <div class="col-md-9">
                    <textarea name="subject" class="form-control" rows="1" placeholder="Предмет договора"><?php echo htmlspecialchars(Arr::path($data->values, 'subject', ''), ENT_QUOTES);?></textarea>
                </div>
            </div>
            <?php } ?>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Номер
                    </label>
                </div>
                <div class="col-md-3">
                    <input id="number" name="number" type="text" class="form-control" placeholder="Номер" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" <?php if($isShow){echo 'readonly';}?>>
                </div>
                <div class="col-md-3 record-title">
                    <label>
                        Основной договор
                    </label>
                </div>
                <div class="col-md-3">
                    <?php if($isShow){?><input name="basic_shop_client_contract_id" value="<?php echo $data->values['basic_shop_client_contract_id'];?>" style="display: none;"><?php }?>
                    <select data-basic-url="<?php echo $siteData->actionURLName;?>"
                            id="basic_shop_client_contract_id" name="basic_shop_client_contract_id" class="form-control select2" style="width: 100%" data-contract-id="<?php echo $data->values['basic_shop_client_contract_id'];?>" <?php if($isShow){echo 'disabled';}?>>
                    </select>
                </div>
            </div>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Общая сумма
                    </label>
                </div>
                <div class="col-md-3">
                    <?php if($data->values['client_contract_type_id'] > 100
                        || $data->values['client_contract_type_id'] == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW
                        || $data->values['client_contract_type_id'] == Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL){ ?>
                        <div class="row">
                            <div class="col-md-6">
                                <input data-type="money" data-fractional-length="2" id="amount_total" name="amount" type="text" class="form-control" placeholder="Общая сумма" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true);?>" <?php if($isShow || ($data->values['client_contract_type_id'] > 0 && $data->values['client_contract_type_id'] <= 100)){echo 'readonly';}?>>
                            </div>
                            <div class="col-md-6">
                                <?php if($isShow){?><input name="currency_id" value="<?php echo $data->values['currency_id'];?>" style="display: none;"><?php }?>
                                <select id="currency_id" name="currency_id" class="form-control select2" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
                                    <?php echo $siteData->globalDatas['view::currency/list/list'];?>
                                </select>
                            </div>
                        </div>
                    <?php }else{?>
                        <input data-type="money" data-fractional-length="2" id="amount_total" name="amount" type="text" class="form-control" placeholder="Общая сумма" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true);?>" <?php if($isShow || ($data->values['client_contract_type_id'] > 0 && $data->values['client_contract_type_id'] <= 100)){echo 'readonly';}?>>
                    <?php }?>
                </div>
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Остаток
                    </label>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Остаток" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'balance_amount', ''), true, 3);?>" readonly>
                </div>
            </div>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Начало
                    </label>
                </div>
                <div class="col-md-3">
                    <input name="from_at" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'from_at', ''));?>" <?php if($isShow){echo 'readonly';}?>>
                </div>
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Окончание
                    </label>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-6">
                            <input name="to_at" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'to_at', ''));?>" <?php if($isShow){echo 'readonly';}?>>
                        </div>
                        <div class="col-md-6">
                            <label class="span-checkbox">
                                <input name="is_perpetual" value="0" style="display: none;">
                                <input name="is_perpetual" <?php if (Arr::path($data->values, 'is_perpetual', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
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
                        <?php if($isShow){?><input name="shop_client_contract_storage_id" value="<?php echo $data->values['shop_client_contract_storage_id'];?>" style="display: none;"><?php }?>
                        <select id="shop_client_contract_storage_id" name="shop_client_contract_storage_id" class="form-control select2" style="width: 100%" <?php if($isShow){echo 'disabled';}?>>
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
                    <textarea name="text" class="form-control" placeholder="Примечание" <?php if($isShow){echo 'readonly';}?>><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
                </div>
            </div>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title"></div>
                <div class="col-md-9">
                    <label class="span-checkbox">
                        <input name="is_add_basic_contract"  <?php if (Arr::path($data->values, 'is_add_basic_contract', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){echo 'disabled';}?>>
                        Сумму товаров плюсовать к основному договору?
                    </label>
                    <span class="link-muted">(влияет на итоговую сумму основного договора)</span>
                </div>
            </div>
            <div class="row" style="margin-top: 30px">
                <div class="col-md-12">
                    <h3>
                        Товары
                    </h3>
                </div>
                <div id="contract-items" class="col-md-12" style="overflow-x: auto">
                    <?php echo $siteData->globalDatas['view::_shop/client/contract/item/list/item'];?>
                </div>
            </div>

            <div class="row">
                <div hidden>
                    <?php if($siteData->action != 'clone') { ?>
                        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
                    <?php } ?>
                    <input id="is_close" name="is_close" value="1" style="display: none">
                </div>
                <div class="modal-footer text-center">
                    <?php if(!$isShow){?>
                        <button type="button" class="btn bg-green" onclick="$('#is_close').val(0); submitButton('', 'shopclientcontract', true);">Применить</button>
                        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(1); submitButton('', 'shopclientcontract', true);">Сохранить</button>
                    <?php }?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index?is_public_ignore=1'); ?>" class="btn btn-primary">Закрыть</a>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-files" style="padding-top: 20px;">
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        Файл
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
                    <div>
                        <b>Примечание</b><br>
                        К каждому документу необходимо прикреплять только <b>один</b> файл.
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 40px">
                <div class="modal-footer text-center">
                    <?php if(!$isShow){?>
                        <button type="button" class="btn bg-green" onclick="$('#is_close').val(0); submitButton('', 'shopclientcontract', true);">Применить</button>
                        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(1); submitButton('', 'shopclientcontract', true);">Сохранить</button>
                    <?php }?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index?is_public_ignore=1'); ?>" class="btn btn-primary">Закрыть</a>
                </div>
            </div>
        </div>

        <?php
        foreach ($listPrint as $keyContract => $print){
            if(strtotime(Arr::path($print, 'date_from', '2000-01-01')) > strtotime($data->values['from_at']) || strtotime(Arr::path($print, 'date_to', '2222-01-01')) < strtotime($data->values['from_at'])){
                continue;
            }
            ?>
            <div data-id="contract-tab" class="tab-pane fade" id="print_<?php echo $keyContract;?>" style="padding-top: 20px;">
                <div class="row">
                    <div style="width: calc(100% - 700px); max-width: 50%" class="col-xs-6">
                        <div>
                            <a data-action="contract-print" data-file="<?php echo $print['file']; ?>" href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/save_pdf', array(), array('id' => $data->id, 'file' => $print['file'])); ?>" class="btn bg-blue btn-flat">
                                <i class="fa fa-fw fa-print"></i>
                                <?php echo $print['bottom'];?>
                            </a>
                            <?php if(!$isShow){?>
                                <button type="button" class="btn bg-green pull-right" onclick="submitButton('<?php echo $print['file']; ?>', 'shopclientcontract', false);">Применить изменения</button>
                            <?php }?>
                        </div>
                        <h4><b>Значения из справочника</b></h4>
                        <table class="table table-hover table-db table-tr-line" >
                            <tr>
                                <th>Название</th>
                                <th>Значение</th>
                            </tr>
                            <tbody>
                            <?php
                            $params = $print['contract_template_others'];
                            foreach ($params as $key => $title){
                                ?>
                                <tr>
                                    <?php if(is_array($title)){ ?>
                                        <td><?php echo $title['name'];?></td>
                                        <td>
                                            <a href="#" data-id="<?php echo $key;?>" data-action="edit-template" data-file="<?php echo $print['file']; ?>" data-url="<?php echo $title['url'];?>" data-field="<?php echo $title['field'];?>" data-title="<?php echo $title['name'];?>"><?php $tmp = Arr::path($values, $key, ''); if(empty($tmp)){$tmp = '<i class="fa fa-fw fa-paste"></i>';} echo $tmp;?></a>
                                        </td>
                                    <?php }else{ ?>
                                        <td><?php echo $title;?></td>
                                        <td>
                                            <?php echo Arr::path($values, $key, '');?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <?php
                            $params = $print['contract_template_params'];
                            foreach ($params as $key => $param){
                                ?>
                                <div class="col-md-12">
                                    <h4><b><?php echo $param['title'];?></b></h4>
                                    <?php foreach ($param['values'] as $value){?>
                                        <p class="span-checkbox">
                                            <input data-action="radio-contract" name="index[<?php echo $print['file'];?>][<?php echo $key;?>]" type="radio" class="minimal" <?php if($value == Arr::path($data->values['options'], 'contract_template_params.' . $print['file'] . '.' . $key, '')){?> checked <?php }?>>
                                            <span><?php echo $value;?></span>
                                        </p>
                                    <?php }?>
                                    <textarea data-contract="#contract-text-<?php echo $keyContract;?>" data-action="contract_template_params" data-file="<?php echo $print['file'];?>" data-id="params.<?php echo $key;?>" rows="3" name="options[contract_template_params][<?php echo $print['file'];?>][<?php echo $key;?>]" type="text" class="form-control"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'contract_template_params.' . $print['file'] . '.' . $key, ''), ENT_QUOTES);?></textarea>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="col-xs-6 box-contract-text" data-id="contract-template" data-contract="<?php echo $print['file'];?>" id="contract-text-<?php echo $keyContract;?>">
                        <?php
                        if(!key_exists($print['file'], $data->values['contract_templates'])){
                            $contractTexts = Arr::path($print, 'contract_templates');
                        }else{
                            $contractTexts = $data->values['contract_templates'][$print['file']];
                        }

                        if(!empty($contractTexts)) {
                            foreach (Arr::path($contractTexts, 'body', array()) as $childText) {
                                $contractText = $childText['text'];

                                $params = $print['contract_template_others'];
                                foreach ($params as $key => $title) {
                                    $value = Arr::path($values, $key);
                                    if (empty($value)) {
                                        $value = '<span class="text-red">' . Arr::path($title, 'name', $title) . '</span>';
                                    }

                                    $contractText = mb_str_replace('{#' . $key . '#}', $value, $contractText);
                                }

                                $params = $print['contract_template_params'];
                                foreach ($params as $key => $param) {
                                    $value = Arr::path($data->values['options'], 'contract_template_params.' . $print['file'] . '.' . $key);
                                    if (empty($value)) {
                                        $value = '<span class="text-red">' . $param['title'] . '</span>';
                                    }

                                    $contractText = mb_str_replace('{#params.' . $key . '#}', $value, $contractText);
                                }

                                foreach ($values as $key1 => $param) {
                                    if (!is_array($param)) {
                                        continue;
                                    }
                                    foreach ($param as $key2 => $value) {
                                        $contractText = mb_str_replace('{#' . $key1 . '.' . $key2 . '#}', $value, $contractText);
                                    }
                                }

                                // добавляем таблицу товаров филиалов
                                /** @var MyArray $items */
                                $params = $data->additionDatas['shop_client_contract_items'];

                                $beginBranch = mb_strpos($contractText, '{#shop_branches.begin#}');
                                if ($beginBranch !== false) {
                                    $endBranch = mb_strpos($contractText, '{#shop_branches.end#}', $beginBranch);
                                    if ($endBranch !== false) {
                                        $templateBranch = mb_substr($contractText, $beginBranch + strlen('{#shop_branches.begin#}'), $endBranch - $beginBranch - strlen('{#shop_branches.begin#}'));

                                        $begin = mb_strpos($templateBranch, '{#shop_client_contract_items.begin#}');
                                        if ($begin !== false) {
                                            $end = mb_strpos($templateBranch, '{#shop_client_contract_items.end#}', $begin);
                                            if ($end !== false) {
                                                $template = mb_substr($templateBranch, $begin + strlen('{#shop_client_contract_items.begin#}'), $end - $begin - strlen('{#shop_client_contract_items.begin#}'));

                                                $items = array();
                                                foreach ($params->childs as $child) {
                                                    $shop = $child->getElementValue('shop_product_id', 'shop_id', 0);
                                                    if (!key_exists($shop, $items)) {
                                                        $items[$shop] = array(
                                                            'text' => '',
                                                            'shop' => $child,
                                                            'field' => 'shop_id',
                                                            'index' => 1,
                                                        );
                                                    }


                                                    $items[$shop]['text'] .= mb_str_replace('#index#',$items[$shop]['index']++,
                                                        mb_str_replace('{#shop_client_contract_items.name#}', $child->getElementValue('shop_product_id', 'name', $child->getElementValue('shop_product_rubric_id')),
                                                            mb_str_replace('{#shop_client_contract_items.quantity#}', Func::getNumberStr($child->values['quantity'], true, 3, true),
                                                                mb_str_replace('{#shop_client_contract_items.price#}', Func::getNumberStr($child->values['price'], true, 2, false),
                                                                    mb_str_replace('{#shop_client_contract_items.amount#}', Func::getNumberStr($child->values['amount'], true, 2, false),
                                                                        mb_str_replace('{#shop_client_contract_items.unit#}', $child->getElementValue('shop_product_id', 'unit'), $template)
                                                                    )
                                                                )
                                                            )
                                                        )
                                                    );
                                                }

                                                $itemsBranch = '';
                                                foreach ($items as $child) {
                                                    $itemsBranch .= mb_str_replace(
                                                        '{#shop_branches.address#}',
                                                        Arr::path(json_decode($child['shop']->getElementValue($child['field'], 'options'), true), 'requisites.address', ''),
                                                        mb_str_replace('{#shop_client_contract_items.begin#}' . $template . '{#shop_client_contract_items.end#}', $child['text'], $templateBranch)
                                                    );
                                                }
                                                $contractText = mb_str_replace('{#shop_branches.begin#}' . $templateBranch . '{#shop_branches.end#}', $itemsBranch, $contractText);
                                            }
                                        }
                                    }
                                }

                                // добавляем таблицу товаров
                                $params = $data->additionDatas['shop_client_contract_items'];
                                $begin = mb_strpos($contractText, '{#shop_client_contract_items.begin#}');
                                if ($begin !== false) {
                                    $end = mb_strpos($contractText, '{#shop_client_contract_items.end#}', $begin);
                                    if ($end !== false) {
                                        $template = mb_substr($contractText, $begin + strlen('{#shop_client_contract_items.begin#}'), $end - $begin - strlen('{#shop_client_contract_items.begin#}'));

                                        $index = 1;
                                        $items = '';
                                        foreach ($params->childs as $child) {
                                            $items .= mb_str_replace('#index#', $index++,
                                                mb_str_replace('{#shop_client_contract_items.name#}', $child->getElementValue('shop_product_id', 'name', $child->getElementValue('shop_product_rubric_id')),
                                                    mb_str_replace('{#shop_client_contract_items.quantity#}', Func::getNumberStr($child->values['quantity'], true, 3, false),
                                                        mb_str_replace('{#shop_client_contract_items.price#}', Func::getNumberStr($child->values['price'], true, 2, false),
                                                            mb_str_replace('{#shop_client_contract_items.amount#}', Func::getNumberStr($child->values['amount'], true, 2, false),
                                                                mb_str_replace('{#shop_client_contract_items.unit#}', $child->getElementValue('shop_product_id', 'unit'), $template)
                                                            )
                                                        )
                                                    )
                                                )
                                            );

                                            if (!is_array($child)) {
                                                continue;
                                            }
                                        }
                                        $contractText = mb_str_replace('{#shop_client_contract_items.begin#}' . $template . '{#shop_client_contract_items.end#}', $items, $contractText);
                                    }
                                }

                                if ($childText['type'] == 'goods') {
                                    $contractText .= '<input data-id="goods-template" value="' . htmlspecialchars($childText['text'], ENT_QUOTES) . '" style="display: none"> ';
                                }

                                echo '<div data-type="' . $childText['type'] . '">' . $contractText . '</div>';
                            }
                        }
                        ?>
                        <?php if(!empty($contractTexts)) {?>
                        <input name="contract_templates[<?php echo $print['file'];?>][header]" value="<?php echo htmlspecialchars($print['header'], ENT_QUOTES); ?>" style="display: none">
                        <input name="contract_templates[<?php echo $print['file'];?>][footer]" value="<?php echo htmlspecialchars($print['footer'], ENT_QUOTES); ?>" style="display: none">
                        <?php }?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <script>
            $(document).ready(function () {
                $('[data-action="radio-contract"]').on('change', function(){
                    var parent = $(this).closest('.span-checkbox');
                    var s = parent.children('span').text();
                    parent.parent().find('textarea').val(s).trigger('change');
                });
            });
        </script>
    </div>
    <div class="row" style="margin-top: 30px">
        <div class="col-md-12">
            <h3>
                Дополнительные соглашения
            </h3>
        </div>
        <div class="col-md-12" style="overflow-x: auto">
            <?php echo $siteData->globalDatas['view::_shop/client/contract/list/agreement'];?>
        </div>
    </div>
</form>
<div id="modal-template-edit" class="modal fade modal-image">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="padding: 30px 34px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть" style="margin: -40px -40px 0px 0px;"><span aria-hidden="true">×</span></button>
                <form action="" method="get" class="modal-fields">
                    <div class="form-group">
                        <label data-id="title">Абзац</label>
                        <textarea data-id="name" name="" placeholder="Абзац" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="text-center">
                        <input name="id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none">
                        <button data-action="template-update" type="button" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function boxDynamic(elements) {
        elements.click(function () {
            var parent = $(this).closest('div[data-id="contract-tab"]');

            parent.find('[data-action="contract_template_params"][data-id="'+$(this).data('id')+'"]').focus().select();
        });
    }
    function boxStatic(elements) {
        elements.click(function () {
            $('[data-action="edit-template"][data-id="' + $(this).data('id') + '"]').trigger('click');
        });
    }
    $(document).ready(function () {
        $('[data-action="edit-template"]').click(function () {
            var modal = $('#modal-template-edit');

            var title = $(this).data('title');
            var field = $(this).data('field');
            var id = $(this).data('id');
            var url = $(this).data('url');

            modal.find('[data-id="title"]').text(title);
            modal.find('[data-id="name"]').val($(this).text())
                .attr('placeholder', title)
                .attr('name', field);

            modal.find('[data-action="template-update"]').data('id', id);

            modal.find('form').attr('action', '/<?php echo $siteData->actionURLName; ?>/' + url + '/save');

            modal.modal('show');
        });

        // событие сохранить
        $('[data-action="template-update"]').click(function (e) {
            e.preventDefault();

            var id = $(this).data('id');

            var form = $(this).closest('form');
            var value = form.find('[data-id="name"]').val();

            var msg = form.serializeArray();
            var href = form.attr('action');
            $.ajax({
                type: 'POST',
                url: href,
                data: msg,
                success: function(data) {
                    $('a[data-id="' + id + '"]').html(value);
                    $('span[data-id="' + id + '"]').html(value);

                    $('#modal-template-edit').modal('hide');

                    <?php foreach ($listPrint as $keyContract => $print){?>
                    isCheckPrint('<?php echo $print['file']; ?>');
                    <?php } ?>
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        $('#shop_client_id').change(function () {
            var basicURL = $(this).data('basic-url');
            var client = $(this).val();
            loadBasicContract(client, $('#basic_shop_client_contract_id'), basicURL);
        }).trigger('change');

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

        $('[data-action="contract_template_params"]').change(function () {
            var contract = $($(this).data('contract'));
            contract.find('[data-id="'+$(this).data('id')+'"]').html($(this).val().replace(/\\n/g,'<br>').replace(/\n/g,'<br>'));
        });

        boxDynamic($('[class="box-dynamic"]'));
        boxStatic($('[class="box-static"]'));
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
                'id_not': (<?php echo $data->id;?>),
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

    function isCheckPrint(file) {
        if(file == ''){
            return;
        }

        var isAll = true;
        $('[data-action="contract_template_params"][data-file="'+file+'"]').each(function () {
            isAll = isAll && $(this).val() != '';
        });

        $('[data-action="edit-template"][data-file="'+file+'"]').each(function () {
            isAll = isAll && $(this).text() != '';
        });

        if(isAll){
            $('[data-action="contract-print"][data-file="'+file+'"]').css('display', 'initial');
        }else{
            $('[data-action="contract-print"][data-file="'+file+'"]').css('display', 'none');
        }
    }

    function submitButton(file, id, isLoad) {

        var form = $('#' + id);
        if(checkRequired(form)) {
            var formData = new FormData(form[0]);

            var list = {};
            $('[data-id="contract-template"]').each(function () {
                var id = $(this).data('contract');
                $(this).children('[data-type="text"], [data-type="goods"]').each(function (i) {
                    var type = $(this).data('type');

                    formData.append('contract_templates[' + id + '][body][' + i + '][type]', type);

                    var text = '';
                    if (type == 'text') {
                        $(this).find('[class="box-dynamic"], [class="box-static"]').each(function (i) {
                            var one = {};
                            one['id'] = $(this).data('id');
                            one['contract'] = id;
                            one['html'] = $(this).html();
                            list[$(this).data('id') + id] = one;

                            $(this).html('{#' + $(this).data('id') + '#}');
                        });

                        text = $(this).html();
                    }else{
                        text = $(this).find('input[data-id="goods-template"]').val();
                    }

                    formData.append('contract_templates[' + id + '][body][' + i + '][text]', text);

                });
            });

            formData.append('json', 1);

            var url = form.attr('action');
            jQuery.ajax({
                url: url,
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    if(isLoad) {
                        var obj = jQuery.parseJSON($.trim(data));

                        if ($('#is_close').val() == 1) {
                            window.location.href = '/<?php echo $siteData->actionURLName; ?>/shopclientcontract/index';
                        } else {
                            window.location.href = '/<?php echo $siteData->actionURLName; ?>/shopclientcontract/edit?id=' + obj.values.id;
                        }
                    }else{
                        $.each(list, function (name, value) {
                            var s = $('[data-contract="' + value['contract'] + '"] [data-id="' + value['id'] + '"]').html(value['html']);
                        });

                        isCheckPrint(file);
                    }
                },
                error: function (data) {
                }
            });
        }
    }

    <?php foreach ($listPrint as $keyContract => $print){?>
    isCheckPrint('<?php echo $print['file']; ?>');
    <?php } ?>
</script>
<?php if($siteData->operation->getIsAdmin() || $data->values['basic_shop_client_contract_id'] > 0){ ?>
    <div id="modal-contract-edit" class="modal fade modal-image">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="padding: 30px 34px 20px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть" style="margin: -40px -40px 0px 0px;"><span aria-hidden="true">×</span></button>
                    <div class="modal-fields">
                        <div class="form-group">
                            <label>Абзац</label>
                            <textarea id="p_text" name="p_text" placeholder="Абзац" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="text-center">
                            <button data-action="p-update" type="button" class="btn btn-primary">Применить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery.fn.outerHTML = function(s) {
            return s
                ? this.before(s).remove()
                : jQuery("<p>").append(this.eq(0).clone()).html();
        };

        CKEDITOR.replace('p_text');
        var pSelect;

        function pContract(elements) {
            elements.dblclick(function () {
                pSelect = $(this);
                CKEDITOR.instances.p_text.setData($(this).outerHTML());
                $('#modal-contract-edit').modal('show');
            });
        }
        pContract($('[data-id="contract-template"] p'));

        $('[data-action="p-update"]').click(function () {
            var text = $(CKEDITOR.instances.p_text.getData());
            pSelect.replaceWith(text);
            pSelect = text;

            if(pSelect.html() == ''){
                pSelect.remove();
            }else {
                boxDynamic(pSelect.find('[class="box-dynamic"]'));
                boxStatic(pSelect.find('[class="box-static"]'));
                pContract(pSelect);
            }

            $('#modal-contract-edit').modal('hide');
        });
    </script>
<?php } ?>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/ab1/fonts/style.css">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/ab1/fonts/DejaVuSans/stylesheet.css">
<style>
    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
        padding: 5px;
    }
    .box-contract-text{
        background-image: url(/css/ab1/img/page_word.jpg);
        background-size: 100% auto;
        width: 700px;
        font-family: 'DejaVu Sans';
        font-size: 11pt;
    }
    .box-contract-text table{
        margin-bottom: 10px;
    }
    body{
        line-height: 1.38;
    }
</style>