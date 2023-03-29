<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/'.$siteData->actionURLName.'/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Подразделение (добавление)'; ?>
                <form enctype="multipart/form-data" action="<?php echo Func::getFullURL($siteData, '/shopmoveclient/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/move/client/one/new']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
