<?php $siteData->siteTitle =  'Расшифровка баланса клиента'; ?>
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
                <?php $siteData->titleTop = 'Расшифровка баланса клиента'; ?>
                <?php
                $view = View::factory('ab1/pto/35/main/_shop/act/revise/item/filter/client');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/act/revise/item/list/virtual']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
