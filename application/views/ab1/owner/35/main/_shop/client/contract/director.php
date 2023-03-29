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
                <?php
                $view = View::factory('ab1/owner/35/main/_shop/client/contract/filter/director');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px; overflow-x: inherit;">
                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/director', array(), array('to_at_from_equally' => date('Y-m-d'), 'to_at_to' => Helpers_DateTime::plusMonth(date('Y-m-d'), 1)));?>" class="btn <?php if(Request_RequestParams::getParamDate('to_at_from_equally') != null){ ?>bg-green<?php }else{ ?>bg-blue<?php }?> btn-flat"> Один месяц до окончания</a>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/director', array(), array('to_at_from_equally' => '', 'to_at_to' => ''));?>" class="btn <?php if(Request_RequestParams::getParamDate('to_at_from_equally') == null){ ?>bg-green<?php }else{ ?>bg-blue<?php }?> btn-flat"> Все договора</a>
                    <?php echo trim($data['view::_shop/client/contract/list/director']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
