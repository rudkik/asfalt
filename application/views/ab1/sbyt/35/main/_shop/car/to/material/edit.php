<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/sbyt/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Автомобиль (просмотр)'; ?>
                <form id="shopcartomaterial" action="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/car/to/material/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>