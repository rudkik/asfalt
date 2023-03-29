<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/nbc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php
                $view = View::factory('ab1/nbc/35/main/_shop/boxcar/filter/index');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_date_departure_empty', '1') == 0){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index', array(), array('is_date_departure_empty' => 0));?>">Убывшие</a></li>
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_date_departure_empty', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index', array(), array('is_date_departure_empty' => 1, 'is_date_arrival_empty' => 0));?>">На территории</a></li>
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_date_drain_to_empty', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index', array(), array('is_date_drain_from_empty' => 0, 'is_date_drain_to_empty' => 1));?>">На разгрузке</a></li>
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_date_arrival_empty', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index', array(), array('is_date_arrival_empty' => 1));?>" data-id="is_date_arrival_empty">Неприбывшие</a></li>
                        <li class="<?php if(Func::not_key_exists(array('is_delete', 'is_date_departure_empty', 'is_date_drain_to_empty', 'is_date_arrival_empty'), $siteData->urlParams) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    </ul>
                </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/boxcar/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
