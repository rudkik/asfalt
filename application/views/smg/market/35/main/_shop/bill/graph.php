<div class="tab-pane active">
    <?php $siteData->titleTop = 'График заказов'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/bill/filter/graph');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <h2>Кол-во заказов</h2>
        <?php echo trim($data['view::_shop/bill/one/graph']); ?>
    </div>
</div>



