<?php $tareTypeID = Request_RequestParams::getParamInt('tare_type_id'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Номер
        </label>
    </div>
    <div class="col-md-3">
        <input id="name" name="name" data-type="auto-number" type="text" class="form-control" placeholder="Номер" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Водитель
        </label>
    </div>
    <div class="col-md-3">
        <input id="driver" name="driver" type="text" class="form-control" placeholder="Водитель">
    </div>
</div>
<?php if($tareTypeID == Model_Ab1_TareType::TARE_TYPE_CLIENT){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Клиент
            </label>
        </div>
        <div class="col-md-9">
            <div class="input-group">
                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                        id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                </select>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Транспортная компания
            </label>
        </div>
        <div class="col-md-9">
            <div class="input-group">
                <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Транспорт АТЦ
            </label>
        </div>
        <div class="col-md-9">
            <div class="input-group">
                <select id="shop_transport_id" name="shop_transport_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/transport/list/list']; ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if($siteData->operation->getIsAdmin()){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Вес
            </label>
        </div>
        <div class="col-md-9">
            <input data-type="money" data-fractional-length="3" id="weight" name="weight" type="text" class="form-control" placeholder="Вес" required>
        </div>
    </div>
<?php } ?>
<div class="row">
    <input name="tare_type_id" value="<?php echo $tareTypeID; ?>" style="display: none">
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
