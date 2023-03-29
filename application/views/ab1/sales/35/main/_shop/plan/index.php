<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/sales/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php
                $view = View::factory('ab1/sales/35/main/_shop/plan/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopplan/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopplanitem/table')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopplanitem/table', array(), array());?>">Таблица <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopplan/index') && (Arr::path($siteData->urlParams, 'is_delete', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopplan/index', array(), array());?>">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopplan/new', array());?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить
                            </a>
                        </li>
                    </ul>
                </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::_shop/plan/list/index']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
