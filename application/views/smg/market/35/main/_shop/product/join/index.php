<div class="tab-pane active">
    <?php $siteData->titleTop = 'Статистика распознаний'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/product/join/filter');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/product/join/list/index']); ?>
    </div>
</div>
