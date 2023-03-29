<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/sales/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Заявка (редактирование)'; ?>
                <form action="<?php echo Func::getFullURL($siteData, '/shopplan/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/plan/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>