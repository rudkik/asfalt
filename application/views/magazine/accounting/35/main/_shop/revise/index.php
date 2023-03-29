<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('magazine/accounting/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <?php
            $view = View::factory('magazine/accounting/35/main/_shop/revise/filter');
            $view->siteData = $siteData;
            $view->data = $data;
            echo Helpers_View::viewToStr($view);
            ?>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoprevise/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1, 'is_group' => '1'));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if(($siteData->url != '/'.$siteData->actionURLName.'/shoprevise/index_edit') && ($siteData->url != '/'.$siteData->actionURLName.'/shoprevise/sort') && (Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoprevise/index', array(), array('is_public_ignore' => 1, 'is_group' => '1'));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/revise/list/index']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
