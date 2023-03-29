<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('magazine/bar/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <?php
            $view = View::factory('magazine/bar/35/main/_shop/realization/special/filter');
            $view->siteData = $siteData;
            $view->data = $data;
            echo Helpers_View::viewToStr($view);
            ?>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/index', array('is_special' => 'is_special'), array('is_delete' => 1, 'is_public_ignore' => 1, 'is_group' => '1', 'is_special' => Request_RequestParams::getParamInt('is_special')));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/index', array('is_special' => 'is_special'), array('is_public_ignore' => 1, 'is_group' => '1', 'is_special' => Request_RequestParams::getParamInt('is_special')));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <a href="<?php echo Func::getFullURL($siteData, '/shoprealization/new?is_special=1', array());?>" class="btn bg-purple btn-flat">
                            <i class="fa fa-fw fa-plus"></i>
                            Добавить
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/realization/list/special/index']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
