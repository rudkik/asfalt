<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/pto/35/main/menu');
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
                    <li class="pull-left header">
                        <div class="btn-group">
                            <a data-action="car-new" href="#" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-plus"></i> Добавить договор</a>
                            <button type="button" class="btn bg-orange btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/new', array(),
                                        array(
                                            'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL,
                                            'client_contract_status_id' => Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK,
                                            'client_contract_kind_id' => Model_Ab1_ClientContract_Kind::CLIENT_CONTRACT_TYPE_BUY,
                                            'subject' => '',
                                            'is_receive' => '0',
                                        )
                                    );?>" class="btn bg-purple btn-flat">
                                        <i class="fa fa-fw fa-plus"></i>
                                        Поставка материалов
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/new', array(),
                                        array(
                                            'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW,
                                            'client_contract_status_id' => Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK,
                                            'client_contract_kind_id' => Model_Ab1_ClientContract_Kind::CLIENT_CONTRACT_TYPE_BUY,
                                            'subject' => '',
                                            'is_receive' => '0',
                                        )
                                    );?>" class="btn bg-purple btn-flat">
                                        <i class="fa fa-fw fa-plus"></i>
                                        Поставка сырья
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/new', array(),
                                        array(
                                            'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_LEASE_CAR,
                                            'client_contract_status_id' => Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK,
                                            'client_contract_kind_id' => Model_Ab1_ClientContract_Kind::CLIENT_CONTRACT_TYPE_BUY,
                                            'subject' => '',
                                            'is_receive' => '0',
                                        )
                                    );?>" class="btn bg-purple btn-flat">
                                        <i class="fa fa-fw fa-plus"></i>
                                        Добавить автоуслугу
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/new', array(),
                                        array(
                                            'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_TRANSPORTATION,
                                            'client_contract_status_id' => Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK,
                                            'subject' => '',
                                            'is_receive' => '0',
                                        )
                                    );?>" class="btn bg-purple btn-flat">
                                        <i class="fa fa-fw fa-plus"></i>
                                        Грузоперевозки
                                    </a>
                                </li>
                            </ul>
                        </div>
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
