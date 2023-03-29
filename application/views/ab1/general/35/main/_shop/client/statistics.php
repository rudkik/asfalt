<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/general/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Реализация по клиентам'; ?>
                <?php
                $view = View::factory('ab1/general/35/main/_shop/client/filter/statistics');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <a href="<?php echo $siteData->urlBasic; ?>/general/shopclient/statistics?shop_branch_id=-1&shop_product_rubric_id=<?php echo Request_RequestParams::getParamInt('shop_product_rubric_id'); ?>" class="btn <?php if(Request_RequestParams::getParamInt('shop_branch_id') < 0){ ?>bg-green<?php }else{?>bg-blue<?php }?> btn-flat">Все филиалы</a>
                    <a href="<?php echo $siteData->urlBasic; ?>/general/shopclient/statistics?is_all=1&shop_branch_id=<?php echo Request_RequestParams::getParamInt('shop_branch_id'); ?>&shop_product_rubric_id=<?php echo Request_RequestParams::getParamInt('shop_product_rubric_id'); ?>" class="btn <?php if(!Request_RequestParams::getParamBoolean('is_debt') && Request_RequestParams::getParamBoolean('is_all')){ ?>bg-green<?php }else{?>bg-blue<?php }?> btn-flat">Все клиенты с начала года</a>
                    <a href="<?php echo $siteData->urlBasic; ?>/general/shopclient/statistics?is_debt=1&is_all=1&shop_branch_id=<?php echo Request_RequestParams::getParamInt('shop_branch_id'); ?>&shop_product_rubric_id=<?php echo Request_RequestParams::getParamInt('shop_product_rubric_id'); ?>" class="btn <?php if(Request_RequestParams::getParamBoolean('is_debt')){ ?>bg-green<?php }else{?>bg-blue<?php }?> btn-flat">Должники</a>
                    <h3 class="pull-right">Текущее время: <span class="text-blue"><?php echo date('d.m.Y H:i'); ?></span></h3>
                    <?php echo trim($data['view::_shop/client/list/statistics']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
