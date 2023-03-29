<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-4">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <label class="col-md-2 control-label"></label>
    <div class="col-md-4">
        <label class="span-checkbox">
            <input name="is_admin" value="0" style="display: none">
            <input name="is_admin" <?php if (Arr::path($data->values, 'is_admin', '1') == 1) { echo ' checked'; } ?> value="1" type="checkbox" class="minimal">
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
        <input name="name" type="text" class="form-control" placeholder="ФИО" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Логин
    </label>
    <div class="col-md-4">
        <input name="email" type="text" class="form-control" placeholder="Логин" required value="<?php echo htmlspecialchars($data->values['email'], ENT_QUOTES);?>">
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

<div class="form-group">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>