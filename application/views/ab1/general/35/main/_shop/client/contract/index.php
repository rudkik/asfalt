<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/general/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'client_contract_status_id', '') == 1389969){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(), array('client_contract_status_id' => 1389969));?>" data-id="is_public_ignore">Отмененные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'client_contract_status_id', '') == 1389728){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(), array('client_contract_status_id' => 1389728));?>" data-id="is_public_ignore">Исполненные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'to_at_from_equally', '') != ''){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(), array('to_at_from_equally' => date('Y-m-d'), 'to_at_to' => Helpers_DateTime::plusMonth(date('Y-m-d'), 1)));?>" data-id="is_public_ignore">Один месяц</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'client_contract_status_id', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(), array('client_contract_status_id' => 1));?>" data-id="is_public_ignore">Действующие</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'to_at_from_equally', '') == '' && Arr::path($siteData->urlParams, 'client_contract_status_id', '') < 1 && Arr::path($siteData->urlParams, 'is_delete', '') != 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header padding-0">
                        <a href="<?php echo Func::getFullURL($siteData, '/shopreport/contract_list', array(), array(), array(), true); ?>" class="btn bg-blue btn-flat" style="margin-right: 10px">Сохранить в Excel</a>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px; overflow-x: inherit;">
                    <?php echo trim($data['view::_shop/client/contract/list/index']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
