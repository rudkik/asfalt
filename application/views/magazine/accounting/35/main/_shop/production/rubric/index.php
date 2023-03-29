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
                <h3>Рубрики продукций</h3>
                <?php
                $view = View::factory('magazine/accounting/35/main/_shop/production/rubric/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproductionrubric/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php if(($siteData->url != '/'.$siteData->actionURLName.'/shopproductionrubric/index_edit') && ($siteData->url != '/'.$siteData->actionURLName.'/shopproductionrubric/sort') && (Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproductionrubric/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopproductionrubric/new', array());?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить рубрику
                            </a>
                        </li>
                    </ul>
                </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::_shop/production/rubric/list/index']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
