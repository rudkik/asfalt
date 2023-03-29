<div class="tab-content">
    <div class="tab-pane active">
        <?php $siteData->titleTop = 'Товары на складе';?>
        <?php $view = View::factory('smg/market/35/main/_shop/receive/item/filter/stock');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);?>
    </div>
    <div class="body-table">
        <div class="box-body table-responsive" style="padding-top: 0px;">
            <?php echo trim($data['view::_shop/receive/item/list/stock']); ?>
        </div>
    </div>
</div>