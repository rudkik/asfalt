<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/zhbibc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1, 'is_group' => '1'));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php if(Request_RequestParams::getParamBoolean('is_public') === false){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/index', array(), array('is_public' => 0));?>"  data-id="is_public">Отказ</a></li>
                        <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Request_RequestParams::getParamBoolean('is_public') !== false)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/index', array(), array());?>">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/new', array());?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить
                            </a>
                        </li>
                    </ul>
                </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::_shop/car/list/index']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
