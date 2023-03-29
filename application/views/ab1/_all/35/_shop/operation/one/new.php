<div hidden>
    <input name="shop_table_rubric_id" value="<?php echo $siteData->interfaceID; ?>">
</div>
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
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_admin" value="0" style="display: none;">
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
    <div class="col-md-3">
        <input name="name" type="text" class="form-control" placeholder="ФИО" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Работник
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_worker_id" name="shop_worker_id" class="form-control select2" style="width: 100%">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list'];?>
        </select>
    </div>
</div>
<?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_ASU){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Место работы
            </label>
        </div>
        <div class="col-md-9">
            <select id="shop_table_select_id" name="shop_table_select_id" class="form-control select2" style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
            </select>
        </div>
    </div>
<?php } ?>
<div class="row record-input record-list">
    <?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_ATC){ ?>
        <div class="col-md-3 record-title">
            <label>
                Вид оператора
            </label>
        </div>
        <div class="col-md-3">
            <select id="operation_type_id" name="operation_type_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::operation-type/list/list'];?>
            </select>
        </div>
    <?php } ?>
    <?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_ABC || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_CASH){ ?>
        <div class="col-md-3 record-title">
            <label>
                Подразделение
            </label>
        </div>
        <div class="col-md-3">
            <select id="shop_subdivision_id" name="shop_subdivision_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/subdivision/list/list']; ?>
            </select>
        </div>
    <?php } ?>
    <?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_KPP){ ?>
        <div class="col-md-3 record-title">
            <label>
                Точка входа
            </label>
        </div>
        <div class="col-md-3">
            <select id="shop_worker_passage_id" name="shop_worker_passage_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/worker/passage/list/list'];?>
            </select>
        </div>
    <?php } ?>
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
<?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_ABC
    || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_CASH
    || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Продразделения работы с продукцией
            </label>
        </div>
        <div class="col-md-9">
            <select id="product_shop_subdivision_ids" name="product_shop_subdivision_ids[]" class="form-control select2" multiple style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/subdivision/list/product']; ?>
            </select>
        </div>
    </div>
<?php } ?>
<?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_ABC
    || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_WEIGHT
    || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Склады с продукцией
            </label>
        </div>
        <div class="col-md-9">
            <select id="product_shop_storage_ids" name="product_shop_storage_ids[]" class="form-control select2" multiple style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/storage/list/product']; ?>
            </select>
        </div>
    </div>
<?php } ?>
<?php if($siteData->interfaceID == 0){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Интерфейс
            </label>
        </div>
        <div class="col-md-9">
            <select id="shop_table_rubric_id" name="shop_table_rubric_id" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::interface/list/list'];?>
            </select>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Интерфейсы для доступа
            </label>
        </div>
        <div class="col-md-9">
            <select multiple id="interface_ids" name="options[interface_ids][]" class="form-control select2" style="width: 100%">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::interface/list/options'];?>
            </select>
        </div>
    </div>
<?php } ?>
<?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_CONTROL || $siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_NBC){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Вид складов
            </label>
        </div>
        <div class="col-md-9">
            <select id="shop_raw_storage_type_id" name="shop_raw_storage_type_id" class="form-control select2"  style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/raw/storage/type/list/list']; ?>
            </select>
        </div>
    </div>
<?php } ?>
<?php if($siteData->interfaceID == Model_Ab1_Shop_Operation::RUBRIC_NBC){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Рубрики сырья
            </label>
        </div>
        <div class="col-md-9">
            <select id="shop_raw_rubric_ids" name="shop_raw_rubric_ids[]" class="form-control select2" multiple style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/raw/rubric/list/list']; ?>
            </select>
        </div>
    </div>
<?php } ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Логин
        </label>
    </div>
    <div class="col-md-3">
        <input name="email" type="text" class="form-control" placeholder="Логин" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Пароль
        </label>
    </div>
    <div class="col-md-3">
        <input name="password" type="password" class="form-control" placeholder="Пароль">
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

