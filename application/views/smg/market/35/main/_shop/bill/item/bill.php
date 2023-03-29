<div class="tab-pane active">
    <?php $siteData->titleTop = 'Товары заказов'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/bill/item/filter/bill');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(Arr::path($siteData->urlParams, 'shop_bill_item_status_id', '') == Model_AutoPart_Shop_Bill_Item_Status::STATUS_OUT_OF_STOCK){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/bill', array(), array('shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_OUT_OF_STOCK));?>" data-id="is_public">Нет в наличие</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'shop_bill_item_status_id', '') == Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_BOOK){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/bill', array(), array('shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_BOOK));?>" data-id="is_public">Бронь у поставщика</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'shop_bill_item_status_id', '') == Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_REQUEST_SUPPLIER){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/bill', array(), array('shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_REQUEST_SUPPLIER));?>" data-id="is_public">Запрос у поставщика</a></li>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/need_buy', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Новые <i class="fa fa-fw fa-info text-blue"></i></a></li>
    </ul>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/bill/item/list/bill']); ?>
    </div>
</div>
