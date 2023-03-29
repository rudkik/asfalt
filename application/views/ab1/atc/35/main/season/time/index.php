<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/atc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Периоды действия сезонов'; ?>
                <?php
                $view = View::factory('ab1/atc/35/main/season/time/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/seasontime/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/seasontime/index', array(), array('is_not_public' => 1));?>" data-id="is_not_public">Неактивные</a></li>
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/seasontime/index', array(), array('is_public' => 1));?>" data-id="is_public">Активные</a></li>
                        <li class="<?php if(($siteData->url != '/'.$siteData->actionURLName.'/season/time/index_edit') && ($siteData->url != '/'.$siteData->actionURLName.'/season/time/sort') && (Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/seasontime/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <?php if (!($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF)){ ?>
                            <a href="<?php echo Func::getFullURL($siteData, '/seasontime/new', array());?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить период
                            </a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::season/time/list/index']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
