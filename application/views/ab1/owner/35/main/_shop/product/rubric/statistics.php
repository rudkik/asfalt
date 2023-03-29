<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/owner/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Реализация'; ?>
                <?php
                $view = View::factory('ab1/owner/35/main/_shop/product/rubric/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 10px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopproductrubric/statistics', array(), array('year' => 2019));?>">2019</a></li>
                    <li class="active"><a href="<?php echo Func::getFullURL($siteData, '/shopproductrubric/statistics', array(), array());?>"><?php echo date('Y'); ?> <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left">
                        <div><a href="<?php echo $siteData->urlBasic; ?>/owner/shopproductrubric/statistics?shop_branch_id=-1" class="btn <?php if(Request_RequestParams::getParamInt('shop_branch_id') < 0){ ?>bg-green<?php }else{?>bg-blue<?php }?> btn-flat">Все филиалы</a></div>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <h3 class="pull-left">Расчетное время: <span class="text-blue">06:00</span></h3>
                    <h3 class="pull-right">Текущее время: <span class="text-blue"><?php echo date('d.m.Y H:i'); ?></span></h3>
                    <?php echo trim($data['view::_shop/product/rubric/list/statistics']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
