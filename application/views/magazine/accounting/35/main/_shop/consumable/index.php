<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('magazine/accounting/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <h3>Расходник <small style="margin-right: 10px;">каталог</small></h3>
                <?php
                $view = View::factory('magazine/accounting/35/main/_shop/consumable/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php if(($siteData->url != '/'.$siteData->actionURLName.'/shopconsumable/index_edit') && ($siteData->url != '/'.$siteData->actionURLName.'/shopconsumable/sort') && (Arr::path($siteData->urlParams, 'is_delete', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/new', array());?>" class="btn bg-purple btn-flat pull-left margin-r-5">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить расходник
                            </a>
                        </li>
                    </ul>
                </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::_shop/consumable/list/index']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
