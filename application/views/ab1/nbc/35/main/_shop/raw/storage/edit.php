<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/nbc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <h3>Сырьевой парк <small style="margin-right: 10px;">редактирование</small></h3>
                <form id="shoprawstorage" action="<?php echo Func::getFullURL($siteData, '/shoprawstorage/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/raw/storage/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>