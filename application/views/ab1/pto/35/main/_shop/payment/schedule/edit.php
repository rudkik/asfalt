<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/pto/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Планируемая оплата (редактирование)'; ?>
                <form id="shoppaymentschedule" action="<?php echo Func::getFullURL($siteData, '/shoppaymentschedule/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/payment/schedule/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
