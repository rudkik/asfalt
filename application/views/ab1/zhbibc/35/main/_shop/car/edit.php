<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/zhbibc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Автомобиль (редактирование)'; ?>
                <form id="shopcar" enctype="multipart/form-data" action="<?php echo Func::getFullURL($siteData, '/shopcar/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/car/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$view = View::factory('ab1/_all/35/_shop/client/one/modal');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/zhbibc/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('ab1/_all/35/_shop/payment/one/modal');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/zhbibc/shoppayment/add_car';
echo Helpers_View::viewToStr($view);
?>