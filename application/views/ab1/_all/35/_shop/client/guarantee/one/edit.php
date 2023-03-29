<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link active" data-toggle="tab" href="#description">Гарантийное письмо</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-files">Скан письма</a>
    </li>
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
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Номер гарантийного письма
                </label>
            </div>
            <div class="col-md-3">
                <input id="number" name="number" type="text" class="form-control" placeholder="Номер гарантийного письма" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" required>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Общая сумма
                </label>
            </div>
            <div class="col-md-3">
                <input id="amount_total" name="amount" type="text" class="form-control" placeholder="Общая сумма" value="<?php echo Func::getNumberStr(Arr::path($data->values, 'amount', ''), true);?>" readonly required>
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
                        id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%" required>
                    <option value="<?php echo $data->values['shop_client_id']; ?>" selected><?php echo htmlspecialchars($data->getElementValue('shop_client_id'), ENT_QUOTES); ?></option>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Дата подачи гарантийного письма
                </label>
            </div>
            <div class="col-md-3">
                <input name="from_at" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'from_at', ''));?>" <?php if($isShow){echo 'readonly';}?> required>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Срок оплаты
                </label>
            </div>
            <div class="col-md-3">
                <input name="to_at" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'to_at', ''));?>" <?php if($isShow){echo 'readonly';}?>>
            </div>
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
        <div class="row record-input record-list" style="margin-top: 30px">
            <div class="col-md-3 record-title">
                <h3 class="pull-right">
                    Продукция
                </h3>
            </div>
            <div class="col-md-9">
                <?php echo $siteData->globalDatas['view::_shop/client/guarantee/item/list/item'];?>
            </div>
        </div>
        <div class="row">
            <div hidden>
                <?php if($siteData->action != 'clone') { ?>
                    <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
                <?php } ?>
            </div>
            <div class="modal-footer text-center">
                <?php if(!$isShow){?>
                    <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
                    <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
                <?php }?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopclientguarantee/index?is_public_ignore=1'); ?>" class="btn btn-primary">Закрыть</a>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab-files" style="padding-top: 20px;">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Дополнительные файлы
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
                <div class="row" style="margin-top: 40px;">
                    <div class="modal-footer text-center">
                        <?php if(!$isShow){?>
                            <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
                            <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
                        <?php }?>
                        <a href="<?php echo Func::getFullURL($siteData, '/shopclientguarantee/index?is_public_ignore=1'); ?>" class="btn btn-primary">Закрыть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>