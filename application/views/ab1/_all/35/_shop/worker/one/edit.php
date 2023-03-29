<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ФИО
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="ФИО" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Код 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="old_id" type="text" class="form-control" placeholder="Код 1С" value="<?php echo htmlspecialchars(Arr::path($data->values, 'old_id', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ИИН
        </label>
    </div>
    <div class="col-md-3">
        <input name="iin" type="text" class="form-control" placeholder="ИИН" value="<?php echo htmlspecialchars(Arr::path($data->values, 'iin', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Филиал
        </label>
    </div>
    <div class="col-md-3">
        <select data-type="select2" id="shop_branch_id" name="shop_branch_id_" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
        </select>
    </div>
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
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>