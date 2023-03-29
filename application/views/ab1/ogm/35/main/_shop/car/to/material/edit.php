<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/ogm/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <h3>Автомобиль <small style="margin-right: 10px;">просмотр</small></h3>
                <form id="shopcartomaterial" action="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/car/to/material/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>