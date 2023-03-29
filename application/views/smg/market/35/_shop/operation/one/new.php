<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-4">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <label class="col-md-2 control-label"></label>
    <div class="col-md-4">
        <label class="span-checkbox">
            <input name="is_admin" value="0" type="checkbox" class="minimal">
            Администратор
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        ФИО
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="ФИО" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Логин
    </label>
    <div class="col-md-4">
        <input name="email" type="text" class="form-control" placeholder="Логин" required>
    </div>
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Пароль
    </label>
    <div class="col-md-4">
        <input name="password" type="password" class="form-control" placeholder="Пароль">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw"></i></sup>
        Должность
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_position_id" name="shop_position_id" class="form-control select2" style="width: 100%">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/position/list/list'];?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw"></i></sup>
        Курьер
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_courier_id" name="shop_courier_id" class="form-control select2" style="width: 100%">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/courier/list/list'];?>
        </select>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
