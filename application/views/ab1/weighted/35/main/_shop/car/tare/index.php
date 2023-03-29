<?php $tareTypeID = Request_RequestParams::getParamInt('tare_type_id'); ?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/weighted/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php if($tareTypeID == Model_Ab1_TareType::TARE_TYPE_CLIENT){ ?>
                    <h3>Машины клиентов</h3>
                <?php }elseif($tareTypeID == Model_Ab1_TareType::TARE_TYPE_OTHER){ ?>
                    <h3>Прочие машины</h3>
                <?php }else{ ?>
                    <h3>Наши машины</h3>
                <?php } ?>
                <?php
                $view = View::factory('ab1/weighted/35/main/_shop/car/tare/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="tab-content">
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index', array('tare_type_id' => 'tare_type_id'), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index', array('tare_type_id' => 'tare_type_id'), array('is_public_ignore' => 1));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/new', array('tare_type_id' => 'tare_type_id'));?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body-table">
                    <div class="box-body table-responsive" style="padding-top: 0px;">
                        <?php echo trim($data['view::_shop/car/tare/list/index']); ?>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
