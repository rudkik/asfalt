<div class="tab-pane active">
    <?php $siteData->titleTop = 'Подочетные товары'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/bill/item/filter/stock-courier');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li <?php if(strpos($siteData->url, '/shopbillitem/stock_transfer')){echo 'class="active"';}?>><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Необходимо принять</a></li>
        <li <?php if(strpos($siteData->url, '/shopbillitem/stock_courier')){echo 'class="active"';}?>><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_courier', array(), array('is_not_public' => 1));?>" data-id="is_not_public">Подочетные</a></li>
    </ul>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/bill/item/list/stock-courier']); ?>
    </div>
</div>
