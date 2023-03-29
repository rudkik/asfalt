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
                <?php echo trim($data['view::_shop/client/contract/item/one/show']); ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/index')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/index', array(), array(), array(), true);?>">Машины</a></li>
                    <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopcaritem/invoice')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcaritem/invoice', array(), array(), array(), true);?>">Накладные</a></li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/invoice/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
