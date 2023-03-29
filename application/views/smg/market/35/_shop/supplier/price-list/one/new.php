<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Поставщик
    </label>
    <div class="col-md-10">
        <select data-type="select2" id="shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
            <?php echo $siteData->globalDatas['view::_shop/supplier/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        С какой строки начать
    </label>
    <div class="col-md-3">
        <input name="first_row" type="phone" class="form-control" placeholder="Номер строки" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Excel-файл
    </label>
    <div class="col-md-10">
        <div class="file-upload" data-text="Выберите Excel-файл">
            <input type="file" name="file">
        </div>
    </div>
</div>
<div class="form-group">
    <h4 class="text-blue" style="padding-left: 15px">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Настройки загрузки
    </h4>
    <div class="col-md-12">
        <table class="table table-hover table-bordered">
            <tr>
                <th>
                    Название <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th style="width: 94px">
                    Шаблон ({1} {4})<a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th>
                    Колонка в Excel-файле <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th>
                    Значение по умолчанию <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th>
                    Формула (<b>#field#</b>*3/5) <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th style="width: 135px">
                    Обязательное <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th style="width: 130px">
                    Соединять по горизонтали <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th style="width: 160px">
                    Соединять по вертикали <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th style="width: 87px">
                    Заменить старое<a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </th>
                <th class="width-90"></th>
            </tr>
            <tbody id="integrations">
            <?php
            $fields = '
<option value="integration">Поле поиска</option>
<option value="article">Артикул</option>
<option value="shop_brand_id.name">Бренд</option>
<option value="name">Название</option>
<option value="tnved">Код ТНВЭД</option>
<option value="quantity">Количество на складе</option>
<option value="text">Описание</option>
<option value="price_cost">Себестоимость</option>
<option value="price">Цена продажи</option>
<option value="barcode">Штрихкод</option>
<option value="url">Ссылка на товар</option>
';

           /* $view = View::factory('smg/market/35/_shop/supplier/price-list/one/integration');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->fields = $fields;
            echo Helpers_View::viewToStr($view);*/
            ?>
            </tbody>
        </table>
        <div class="text-center">
            <button type="button" class="btn btn-warning" onclick="addElement('integration', 'integrations', true, false)"><i class="fa fa-fw fa-plus"></i> Добавить параметр</button>
        </div>

        <div hidden="hidden" id="integration" data-index="1">
            <!--
            <tr>
                <td>
                    <select data-type="select2" name="integrations[#index#][field]" class="form-control select2" style="width: 100%;">
                        <?php echo $fields; ?>
                    </select>
                </td>
                <td class="text-center">
                    <input name="integrations[#index#][is_template]" value="0" data-id="1" type="checkbox" class="minimal">
                </td>
                <td><input name="integrations[#index#][column]" type="text" class="form-control"></td>
                <td><input name="integrations[#index#][default]" type="text" class="form-control"></td>
                <td><input name="integrations[#index#][formula]" type="text" class="form-control"></td>
                <td class="text-center">
                    <input name="integrations[#index#][is_check]" value="0" data-id="1" type="checkbox" class="minimal">
                </td>
                <td class="text-center">
                    <input name="integrations[#index#][is_join_horizontal]" value="0" data-id="1" type="checkbox" class="minimal">
                </td>
                <td><input name="integrations[#index#][join_level_vertical]" type="text" class="form-control" placeholder="Сколько уровней"></td>
                <td class="text-center">
                    <input name="integrations[#index#][is_replace]" value="0" data-id="1" type="checkbox" class="minimal">
                </td>
                <td>
                    <ul class="list-inline tr-button delete">
                        <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                    </ul>
                </td>
            </tr>
             -->
        </div>

    </div>
</div>
<h4 class="text-blue">Разбить на несколько товаров</h4>
<div class="form-group">
    <label class="col-md-2 control-label">
        Колонка для разбивания
    </label>
    <div class="col-md-2">
        <input name="break[column]" type="phone" class="form-control" placeholder="Колонка для разбивания">
    </div>
    <label class="col-md-2 control-label">
        Разделитель
    </label>
    <div class="col-md-1">
        <input name="break[separator]" type="text" class="form-control" placeholder="Разделитель">
    </div>
</div>
<h4 class="text-blue">Ограничение товаров</h4>
<div class="form-group">
    <label class="col-md-2 control-label">
        Колонка наличие товаров
    </label>
    <div class="col-md-2">
        <input name="availability[column]" type="phone" class="form-control" placeholder="Колонка наличие товаров">
    </div>
    <label class="col-md-2 control-label">
        Больше
    </label>
    <div class="col-md-1">
        <input name="availability[quantity_min]" type="text" class="form-control" placeholder="Больше">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Стоимость товара больше
    </label>
    <div class="col-md-2">
        <input name="price_more" type="phone" class="form-control" placeholder="Стоимость товара больше">
    </div>
</div>
<div class="row">
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary pull-left">Сохранить</button>
        <button id="load-products" type="button" class="btn btn-success">Считать товары</button>
    </div>
</div>

<div class="form-group">
    <label class="col-md-12 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Товары из файла
    </label>
    <div id="data" class="col-md-12">
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#load-products').click(function (e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var formData = new FormData(form[0]);

            formData.delete('shop_products');
            jQuery.ajax({
                url: '<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/load_file'); ?>',
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#data').html(data);
                },
                error: function (data) {
                }
            });
        });
    });
</script>
<style>
    .minimal{
        max-width: 100%;
    }
</style>