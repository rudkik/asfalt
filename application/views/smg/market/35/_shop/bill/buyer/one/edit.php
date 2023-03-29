<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Источник
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_source_id" name="shop_source_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/source/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Фамилия
    </label>
    <div class="col-md-10">
        <input name="lastName" type="text" class="form-control" placeholder="Фамилия" value="<?php echo htmlspecialchars($data->values['lastName'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Имя
    </label>
    <div class="col-md-10">
        <input name="firstName" type="text" class="form-control" placeholder="Имя" value="<?php echo htmlspecialchars($data->values['firstName'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Номер телефона
    </label>
    <div class="col-md-10">
        <input name="phone" type="phone" class="form-control" placeholder="Номер телефона" value="<?php echo htmlspecialchars($data->values['phone'], ENT_QUOTES); ?>" >
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
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
