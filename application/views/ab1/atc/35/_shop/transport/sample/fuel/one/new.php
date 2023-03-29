<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Номер
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Номер">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="created_at" type="datetime" date-type="datetime" class="form-control">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Транспортное средство
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_transport_mark_id" name="shop_transport_mark_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/mark/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Пробег
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="milage" type="text" class="form-control" placeholder="Пробег">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ГСМ
        </label>
    </div>
    <div class="col-md-9">
        <?php echo $siteData->globalDatas['view::_shop/transport/sample/fuel/item/list/index'];?>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-fuel', 'fuels', true);">Добавить ГСМ</button>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Комментарий
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>