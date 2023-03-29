<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-3">
                <label class="span-checkbox">
                    <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                    Показать
                </label>
            </div>
            <div class="col-md-3 record-title"></div>
            <div class="col-md-3">
                <label class="span-checkbox">
                    <input name="is_price_cost" <?php if (Arr::path($data->values, 'is_price_cost', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                    Продавать по себестоимости
                </label>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-3">
                <label class="span-checkbox">
                    <input name="is_special" <?php if (Arr::path($data->values, 'is_special', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
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
                <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название в 1С
                </label>
            </div>
            <div class="col-md-3">
                <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_1c', ''), ENT_QUOTES);?>">
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
                <input autocomplete="off" data-type="barcode1" name="barcode" type="tel" class="form-control" placeholder="Штрихкод" value="<?php echo htmlspecialchars(Arr::path($data->values, 'barcode', ''), ENT_QUOTES);?>">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Вес нетто в кг
                </label>
            </div>
            <div class="col-md-3">
                <input name="weight_kg" type="text" class="form-control" placeholder="Вес нетто в кг" value="<?php echo htmlspecialchars(Arr::path($data->values, 'weight_kg', ''), ENT_QUOTES);?>">
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
                <input autocomplete="off"  name="coefficient_rubric" type="tel" class="form-control" placeholder="Коэффициент для рубрики" value="<?php echo htmlspecialchars(Arr::path($data->values, 'coefficient_rubric', ''), ENT_QUOTES);?>">
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
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Себестоимость
                </label>
            </div>
            <div class="col-md-3">
                <input name="price_cost" type="tel" class="form-control" placeholder="Себестоимость" required value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'price_cost', ''));?>">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Цена реализации
                </label>
            </div>
            <div class="col-md-3">
                <input name="price" type="tel" class="form-control" placeholder="Цена реализации" required value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'price', ''));?>">
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
        $view = View::factory('magazine/bar/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-left">
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
</style>