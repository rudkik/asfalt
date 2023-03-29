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
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название АСВА
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название на сайте / прайс-лист
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_site" type="text" class="form-control" placeholder="Название на сайте">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название по реценту
        </label>
    </div>
    <div class="col-md-3">
        <textarea name="name_recipe" class="form-control" placeholder="Название по реценту"></textarea>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Тип продукта
        </label>
    </div>
    <div class="col-md-3">
        <select id="product_type_id" name="product_type_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::product/type/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Вид продукта
        </label>
    </div>
    <div class="col-md-3">
        <select id="product_view_id" name="product_view_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::product/view/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Рубрика
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Группа
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_product_group_id" name="shop_product_group_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/group/list/list']; ?>
        </select>
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
        <input name="unit" type="text" class="form-control" placeholder="Единица измерения" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Цена
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="price" type="phone" class="form-control" placeholder="Цена" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
    </div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_packed" value="0"type="checkbox" class="minimal">
            Фасованный
        </label>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Вес тары
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="tare" type="text" class="form-control" placeholder="Вес тары">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Объём (м<sup>3</sup>)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="volume" type="text" class="form-control" placeholder="Объём">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Коэффициент веса в кол-во (кг в м<sup>3</sup>)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="coefficient_weight_quantity" type="text" class="form-control" placeholder="Коэффициент веса в кол-во">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Подразделение
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_subdivision_id" name="shop_subdivision_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo trim($siteData->globalDatas['view::_shop/subdivision/list/list']); ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место забора продукции
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_storage_id" name="shop_storage_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место забора материала
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_heap_id" name="shop_heap_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Выбрать материал для продукции в соотношении 1 к 1
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Виды рецептов
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="access" name="formula_type_ids[]" class="form-control select2" multiple required style="width: 100%;">
                <?php echo $siteData->globalDatas['view::formula-type/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <h4 class="text-blue">Для прайс-листа</h4>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Сортировка
        </label>
    </div>
    <div class="col-md-3">
        <input name="order" type="text" class="form-control" placeholder="Сортировка">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_pricelist" value="1" checked type="checkbox" class="minimal">
            Вывести в прайс-лист
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="options[amdor_9]" value="0" type="checkbox" class="minimal">
            C добавлением адгезионной присадки «Амдор 9»
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Рубрика прайс-листа
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_product_pricelist_rubric_id" name="shop_product_pricelist_rubric_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/pricelist/rubric/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Размеры
        </label>
    </div>
    <div class="col-md-9" style="max-width: 900px;">
        <table class="table table-hover table-db table-tr-line" >
            <thead>
            <tr>
                <th class="text-center" rowspan="2">Вес (кг)</th>
                <th class="text-center" rowspan="2">Объем (м3)</th>
                <th class="text-center" colspan="3">Размеры (м)</th>
                <th class="text-center" rowspan="2">Площадь (м2)</th>
            </tr>
            <tr>
                <th class="text-center">длина</th>
                <th class="text-center">ширина</th>
                <th class="text-center">высота</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input data-type="money" data-fractional-length="3" name="options[weighted]" type="text" class="form-control" placeholder="Вес (кг)" value="">
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" name="options[volume]" type="text" class="form-control" placeholder="Объем (м3)" value="">
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" name="options[length]" type="text" class="form-control" placeholder="Длина (м)" value="">
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" name="options[width]" type="text" class="form-control" placeholder="Ширина (м)" value="">
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" name="options[height]" type="text" class="form-control" placeholder="Высота (м)" value="">
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" name="options[area]" type="text" class="form-control" placeholder="Площадь (м2)" value="">
                </td>
            </tr>
            </tbody>
        </table>
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

<script>
    $(document).ready(function () {
        $('#shop_subdivision_id').change(function () {
            var subdivision = $(this).val();
            if (subdivision > 0){
                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopstorage/select_options',
                    data: ({
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_storage_id').select2('destroy').empty().html(data).select2().val(-1);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopheap/select_options',
                    data: ({
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_heap_id').select2('destroy').empty().html(data).select2().val(-1);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }else{
                $('#shop_storage_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
            }
        });
    });
</script>
