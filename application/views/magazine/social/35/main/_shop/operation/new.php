<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('magazine/social/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <h3>Оператор <small style="margin-right: 10px;">добавление</small></h3>
                <form action="<?php echo Func::getFullURL($siteData, '/shopoperation/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/operation/one/new']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
