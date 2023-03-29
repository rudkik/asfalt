<div class="tab-pane active">
    <?php $siteData->titleTop = 'Товары заказов'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/bill/item/filter/need-buy');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/bill', array(), array('shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_BUY));?>" data-id="is_public">Куплен</a></li>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/bill', array(), array('shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_OUT_OF_STOCK));?>" data-id="is_public">Нет в наличие</a></li>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/bill', array(), array('shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_BOOK));?>" data-id="is_public">Бронь у поставщика</a></li>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/bill', array(), array('shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_REQUEST_SUPPLIER));?>" data-id="is_public">Запрос у поставщика</a></li>
        <li class="active"><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Новые <i class="fa fa-fw fa-info text-blue"></i></a></li>
        <li class="pull-left header" style="margin-right: 10px">
            <div class="btn-group">
                <button type="button" class="btn btn-success">Считать с сайта</button>
                <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="<?php echo $siteData->urlBasic . '/smg/kaspi/check_bills' . URL::query(['shop_source_id' => 1, 'shop_branch_id' => $siteData->shopID, 'url' => '/market/shopbillitem/need_buy']);?>">Kaspi</a></li>
                </ul>
            </div>
        </li>
        <li class="pull-left header" style="margin-right: 10px">
            <span>
                <a href="<?php echo Func::getFullURL($siteData, '/shopreport/need_buy_bill_items', array(), [], [], true); ?>" class="btn btn-violet">
                    Сохранить в Excel
                </a>
            </span>
        </li>
        <li class="pull-left header" style="margin-right: 10px">
            <span>
                <a data-action="set-supplier" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/supplier', array(), [], [], true); ?>" class="btn btn-blue">
                    Поставщикам
                </a>
            </span>
        </li>
        <li class="pull-left header" style="margin-right: 10px">
            <div class="btn-group">
                <a data-action="set-yandex-map" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/yandex_map', array(), [], [], true); ?>"  class="btn btn-yellow">Яндекс карта</a>
                <button type="button" data-toggle="dropdown" class="btn btn-yellow dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul role="menu" class="dropdown-menu">
                    <li>
                        <a data-action="set-yandex-map-courier" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/set_yandex_map_courier'); ?>">
                            По маршруту задать курьера
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/bill/item/list/need-buy']); ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[data-action="set-supplier"]').click(function (e) {
            e.preventDefault();

            $('#modal-supplier').remove();
            var href = $(this).attr('href');

            jQuery.ajax({
                url: href,
                data: ({}),
                type: "GET",
                success: function (data) {
                    $('body').append(data);
                    $('#modal-supplier').modal('show');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
        $('[data-action="set-yandex-map"]').click(function (e) {
            e.preventDefault();

            $('#modal-yandex-map').remove();
            var href = $(this).attr('href');

            jQuery.ajax({
                url: href,
                data: ({}),
                type: "GET",
                success: function (data) {
                    $('body').append(data);
                    $('#modal-yandex-map').modal('show');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
        $('[data-action="set-yandex-map-courier"]').click(function (e) {
            e.preventDefault();

            var modal = $('#modal-yandex-map-courier');
            modal.modal('show');
            modal.find('form').attr('action', $(this).attr('href'));
        });
        $('[data-action="save-yandex-map-courier"]').click(function (e) {
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
                    location.reload();
                },
                error: function (data) {
                }
            });
        });
    });
</script>
<div id="modal-yandex-map-courier" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Задать курьера</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal-courier-shop_courier_id">Курьер</label>
                    <select data-type="select2" id="modal-courier-shop_courier_id" name="shop_courier_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/courier/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ссылка на маршрут</label>
                    <textarea name="url" rows="5" placeholder="Ссылка на маршрут" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-yandex-map-courier" type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
