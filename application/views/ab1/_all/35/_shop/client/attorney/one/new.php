<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Активная
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Номер доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input id="number" name="number" type="text" class="form-control" placeholder="Номер доверенности">
    </div>
    <div class="col-md-3 record-title">
        <label  style="margin-top: -3px;">
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Общая сумма доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input id="amount_total" type="text" class="form-control" placeholder="Общая сумма доверенности" readonly required>
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
        <div class="input-group">
            <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                    data-contract="#shop_client_contract_id"
                    id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%" required>
            </select>
            <span class="input-group-btn add-client">
                <a href="" class="btn bg-purple btn-flat" data-toggle="modal" data-target="#dialog-client"><i class="fa fa-fw fa-plus"></i> Добавить клиента</a>
            </span>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Договор
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_client_contract_id" name="shop_client_contract_id" data-contract-id="-1" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без договора</option>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Доверительное лицо
        </label>
    </div>
    <div class="col-md-3">
        <input id="client_name" name="client_name" type="text" class="form-control" placeholder="Доверительное лицо" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Начало доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input name="from_at" type="datetime" date-type="date" class="form-control" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Окончание доверенности
        </label>
    </div>
    <div class="col-md-3">
        <input name="to_at" type="datetime" date-type="date" class="form-control">
    </div>
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
<div class="row record-input record-list" style="margin-top: 30px">
    <div class="col-md-3 record-title">
        <h3 class="pull-right">
            Продукция
        </h3>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/client/attorney/item/list/item'];?>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
