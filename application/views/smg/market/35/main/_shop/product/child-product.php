<div class="tab-pane active">
    <?php
    $message = Request_RequestParams::getParamStr('message');
    if (!empty($message)){ ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php }?>
    <?php $siteData->titleTop = 'Связь товаров'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/product/filter/child-product');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/product/list/index']); ?>
    </div>
</div>
