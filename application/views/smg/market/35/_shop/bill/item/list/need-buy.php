<table class="table-green table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-30 text-right">№</th>
        <th class="tr-header-public">
            <span>
                <input type="checkbox" class="minimal" checked disabled>
            </span>
        </th>
        <th class="tr-header-public">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.is_in_stock'); ?>" class="link-black">Нал.</a>
        </th>
        <th class="width-70">
            Фото
        </th>
        <th class="width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.article'); ?>" class="link-black">Артикул</a>
        </th>
        <th class="width-120">
            Интеграция
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Название</a>
        </th>
        <th class="width-170">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.shop_supplier_id.name'); ?>" class="link-black">Поставщики</a>
        </th>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th class="text-right width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во </a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="text-right width-80" style="font-size: 12px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.price_cost'); ?>" class="link-black">Себестоим.</a>
        </th>
        <th class="text-right width-80">
            Доход
        </th>
        <th class="width-95" style="font-size: 12px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'url'); ?>" class="link-black">Ссылка поставщика</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy'). Func::getAddURLSortBy($siteData->urlParams, 'root_shop_product_id.article'); ?>" class="link-black">Связь</a>
        </th>
        <th class="width-85"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    $data = $data['view::_shop/bill/item/one/need-buy'];
    foreach ($data->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
    <tr class="bg-blue">
        <td colspan="10" class="text-right">Итого:</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], true); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['amount'], true); ?></td>
        <td colspan="5"></td>
    </tr>
    </tbody>
</table>
<style>
    .table-green > tbody > tr:nth-child(2n - 1), .table-green > tbody > tr:nth-child(2n - 1) > td {
        background-color: rgba(97, 206, 168, 0.1);
    }
</style>
<script>
    $(document).ready(function () {
        var clickButton = undefined;
        $('[data-status]').click(function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr[data-id="product"]');

            var modal = $('#modal-status');
            modal.modal('show');

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('[name="shop_supplier_id"]').val(tr.data('supplier')).trigger('change');
            modal.find('[name="shop_bill_item_status_id"]').val($(this).data('status')).trigger('change');

            if($(this).data('status') == <?php echo Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_BOOK; ?>){
                modal.find('.modal-title').text('Забронированно у поставщика');
            }
            if($(this).data('status') == <?php echo Model_AutoPart_Shop_Bill_Item_Status::STATUS_OUT_OF_STOCK; ?>){
                modal.find('.modal-title').text('Нет в наличие у поставщика');
            }
            modal.find('h4.text-blue').text(tr.find('[data-id="name"]').text());

            clickButton = $(this);
        });
        $('[data-action="save-status"]').click(function (e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var formData = new FormData(form[0]);

            jQuery.ajax({
                url: form.attr('action'),
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    var modal = $('#modal-status');
                    modal.modal('hide');

                    var select = modal.find('[name="shop_bill_item_status_id"]');
                    var name = select.find('option[data-id="' + select.val() + '"]').text();

                    clickButton.html('Изменить статус <br>' + name + ' +');
                },
                error: function (data) {
                }
            });
        });

        $('[data-action="set-courier"]').click(function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr[data-id="product"]');
            var modal = $('#modal-courier');
            modal.modal('show');

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('h4.text-blue').text('Заказ №' + tr.data('bill'));

            clickButton = $(this);
        });
        $('[data-action="save-courier"]').click(function (e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var formData = new FormData(form[0]);

            jQuery.ajax({
                url: form.attr('action'),
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    var modal = $('#modal-courier');
                    modal.modal('hide');

                    var select = modal.find('[name="shop_courier_id"]');
                    var name = select.find('option[data-id="' + select.val() + '"]').text();

                    clickButton.html('Курьер <br>' + name + ' +');
                },
                error: function (data) {
                }
            });
        });

        $('[data-action="set-receive"]').click(function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr[data-id="product"]');

            var modal = $('#modal-receive');
            modal.modal('show');

            modal.find('[name="quantity"]').val(tr.data('quantity'));
            modal.find('[name="price_cost"]').val(tr.data('price_cost'));

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('h4.text-blue').text('Заказ №' + tr.data('bill') + ' ' + tr.find('[data-id="name"]').text());

            clickButton = $(this);
        });
        $('[data-action="save-receive"]').click(function (e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var formData = new FormData(form[0]);

            jQuery.ajax({
                url: form.attr('action'),
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    var modal = $('#modal-receive');
                    modal.modal('hide');

                    var obj = jQuery.parseJSON($.trim(data));
                    clickButton.html('Закуп №' + obj.number + ' +');
                },
                error: function (data) {
                }
            });
        });

        $('[data-action="set-comment"]').click(function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr');

            var modal = $('#modal-comment');
            modal.modal('show');

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('h4.text-blue').text('Заказ №' + tr.data('bill'));

            modal.find('[name="text"]').val($.trim(tr.find('[data-id="comment"]').text()));

            clickButton = $(this);
        });
        $('[data-action="save-comment"]').click(function (e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var formData = new FormData(form[0]);

            jQuery.ajax({
                url: form.attr('action'),
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    var modal = $('#modal-comment');
                    modal.modal('hide');

                    var tr = clickButton.closest('tr');
                    tr.find('[data-id="comment"]').text(modal.find('[name="text"]').val())
                },
                error: function (data) {
                }
            });
        });

        $('[data-action="set-address"]').click(function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr');

            var modal = $('#modal-address');
            modal.modal('show');

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('h4.text-blue').text('Заказ №' + tr.data('bill'));

            clickButton = $(this);
        });
        $('[data-action="save-address"]').click(function (e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var formData = new FormData(form[0]);

            jQuery.ajax({
                url: form.attr('action'),
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var modal = $('#modal-address');
                    modal.modal('hide');

                    var tr = clickButton.closest('tr');
                    tr.find('[data-id="address"]').text(obj.values.name)
                },
                error: function (data) {
                }
            });
        });
    });
</script>
<div id="modal-status" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Статус</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;"></h4>
                <div class="form-group">
                    <label for="modal-status-shop_bill_item_status_id">Статус</label>
                    <select data-type="select2" id="modal-shop_bill_item_status_id" name="shop_bill_item_status_id" class="form-control select2" required style="width: 100%;">
                        <?php echo trim($siteData->replaceDatas['view::_shop/bill/item/status/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="modal-status-shop_supplier_id">Поставщик</label>
                    <select data-type="select2" id="modal-shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
                        <option value="-1" data-id="-1">Выберите значение</option>
                        <?php echo trim($siteData->replaceDatas['view::_shop/supplier/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Кол-во</label>
                    <input name="quantity" type="text" class="form-control" placeholder="Кол-во" required>
                </div>
            </div>
            <div class="modal-footer">
                <input name="url" value="<?php echo htmlspecialchars(Func::getFullURL($siteData, '/shopbillitem/need_buy') .URL::query(), ENT_QUOTES); ?>" style="display: none">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-status" type="submit" class="btn btn-primary">Установить</button>
            </div>
        </form>
    </div>
</div>
<div id="modal-courier" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Курьер</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;"></h4>
                <div class="form-group">
                    <label for="modal-courier-shop_courier_id">Курьер</label>
                    <select data-type="select2" id="modal-courier-shop_courier_id" name="shop_courier_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/courier/list/list']);?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input name="url" value="<?php echo htmlspecialchars(Func::getFullURL($siteData, '/shopbillitem/need_buy') .URL::query(), ENT_QUOTES); ?>" style="display: none">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-courier" type="submit" class="btn btn-primary">Установить</button>
            </div>
        </form>
    </div>
</div>
<div id="modal-receive" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Закуп товара</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;"></h4>
                <div class="form-group">
                    <label for="date">Дата</label>
                    <input name="date" type="datetime" date-type="date" class="form-control" value="<?php echo date('d.m.Y'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="modal-receive-shop_supplier_address_id">Адрес поставщика</label>
                    <select data-type="select2" id="modal-receive-shop_supplier_address_id" name="shop_supplier_address_id" class="form-control select2" required style="width: 100%;">
                        <option value="-1" data-id="-1">Выберите значение</option>
                        <?php echo trim($siteData->replaceDatas['view::_shop/supplier/address/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="modal-receive-shop_courier_id">Курьер</label>
                    <select data-type="select2" id="modal-receive-shop_courier_id" name="shop_courier_id" class="form-control select2" required style="width: 100%;">
                        <option value="-1" data-id="-1">Выберите значение</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/courier/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price_cost">Цена закупа</label>
                    <input name="price_cost" type="text" class="form-control" placeholder="Цена закупа" required>
                </div>
                <div class="form-group">
                    <label for="commission_supplier">Процент комиссии при покупки у поставщика</label>
                    <input name="commission_supplier" type="text" class="form-control" placeholder="Процент комиссии" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-receive" type="submit" class="btn btn-primary">Добавить в закуп</button>
            </div>
        </form>
    </div>
</div>
<div id="modal-comment" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Комментарий</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;"></h4>
                <div class="form-group">
                    <label>Комментарий</label>
                    <textarea name="text" rows="5" placeholder="Комментарий" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-comment" type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
<div id="modal-address" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Изменить адрес</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;"></h4>
                <div class="form-group">
                    <label for="city">Город</label>
                    <input name="city_name" type="text" class="form-control" value="Алматы" required>
                </div>
                <div class="form-group">
                    <label for="street">Улица</label>
                    <input name="street" type="text" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="house">Дом</label>
                            <input name="house" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apartment">Квартира</label>
                            <input name="apartment" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Ссылка на яндекс карту</label>
                    <textarea name="yandex" rows="5" placeholder="Ссылка на яндекс карту" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-address" type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>