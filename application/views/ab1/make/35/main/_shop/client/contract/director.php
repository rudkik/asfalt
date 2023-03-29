<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/'.$siteData->actionURLName.'/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="body-table">
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'to_at_from_equally', '') == '' && Arr::path($siteData->urlParams, 'client_contract_status_id', '') < 1 && Arr::path($siteData->urlParams, 'is_delete', '') != 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/director', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/director', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="pull-left header">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/director', array(), array('to_at_from_equally' => date('Y-m-d'), 'to_at_to' => Helpers_DateTime::plusMonth(date('Y-m-d'), 1)));?>" class="btn <?php if(Request_RequestParams::getParamDate('to_at_from_equally') != null){ ?>bg-green<?php }else{ ?>bg-blue<?php }?> btn-flat"> Один месяц до окончания</a>
                        </li>
                        <li class="pull-left header padding-0">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/director', array(), array('to_at_from_equally' => '', 'to_at_to' => ''));?>" class="btn <?php if(Request_RequestParams::getParamDate('to_at_from_equally') == null){ ?>bg-green<?php }else{ ?>bg-blue<?php }?> btn-flat"> Все договора</a>
                        </li>
                    </ul>
                </div>
                <div class="box-body table-responsive" style="padding-top: 0px; overflow-x: inherit;">
                    <?php echo trim($data['view::_shop/client/contract/list/director']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
