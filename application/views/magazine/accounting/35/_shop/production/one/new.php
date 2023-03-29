<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-3">
                <label class="span-checkbox">
                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                    Показать
                </label>
            </div>
            <div class="col-md-3 record-title"></div>
            <div class="col-md-3">
                <label class="span-checkbox">
                    <input name="is_price_cost" value="0" data-id="1" type="checkbox" class="minimal">
                    Продавать по себестоимости
                </label>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-3">
                <label class="span-checkbox">
                    <input name="is_special" value="0" type="checkbox" class="minimal">
                    Специальный продукт
                </label>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название
                </label>
            </div>
            <div class="col-md-3">
                <input name="name" type="text" class="form-control" placeholder="Название" required>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название в 1С
                </label>
            </div>
            <div class="col-md-3">
                <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    ID 1C
                </label>
            </div>
            <div class="col-md-3">
                <input name="old_id" type="text" class="form-control" placeholder="ID 1C">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Штрихкод
                </label>
            </div>
            <div class="col-md-3">
                <input autocomplete="off"  name="barcode" type="tel" class="form-control" placeholder="Штрихкод">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Вес нетто в кг
                </label>
            </div>
            <div class="col-md-3">
                <input name="weight_kg" type="text" class="form-control" placeholder="Вес нетто в кг">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Рубрика
                </label>
            </div>
            <div class="col-md-3">
                <select data-type="select2" id="shop_production_rubric_id" name="shop_production_rubric_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/production/rubric/list/list']; ?>
                </select>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Коэффициент для рубрики
                </label>
            </div>
            <div class="col-md-3">
                <input autocomplete="off"  name="coefficient_rubric" type="tel" class="form-control" placeholder="Коэффициент для рубрики" value="1">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Единица измерения
                </label>
            </div>
            <div class="col-md-3">
                <select data-type="select2" id="unit_id" name="unit_id" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::unit/list/list']; ?>
                </select>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Цена реализации
                </label>
            </div>
            <div class="col-md-3">
                <input name="price" type="tel" class="form-control" placeholder="Цена реализации" required>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Рецепт
                </label>
            </div>
            <div class="col-md-9">
                <?php echo $siteData->globalDatas['view::_shop/production/item/list/index'];?>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="addProduction('new-product', 'products', true);">Добавить строчку</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $view = View::factory('magazine/accounting/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<style>
    .record-input.record-list > .col-md-3 {
        width: calc((100% - 340px) / 2);
    }
    .record-input > .record-title {
        width: 170px !important;
    }
    .record-input.record-list > .col-md-3, .record-input.record-list > .col-md-9 {
        width: calc(100% - 170px);
    }
</style>