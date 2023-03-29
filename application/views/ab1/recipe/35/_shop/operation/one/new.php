<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_admin" value="0" type="checkbox" class="minimal">
            Администратор
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ФИО
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="ФИО" required>
    </div>
</div>
<div class="row record-input record-list">
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
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Логин
        </label>
    </div>
    <div class="col-md-9">
        <input name="email" type="text" class="form-control" placeholder="Логин" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Пароль
        </label>
    </div>
    <div class="col-md-9">
        <input name="password" type="password" class="form-control" placeholder="Пароль">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Доступные виды рецептов
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="access" name="access[formula_type_ids][]" class="form-control select2" multiple required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::formula-type/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="shop_table_rubric_id" value="<?php echo Model_Ab1_Shop_Operation::RUBRIC_RECEPE; ?>">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
