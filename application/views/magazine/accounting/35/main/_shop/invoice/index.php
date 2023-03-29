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
            $view = View::factory('magazine/accounting/35/main/_shop/invoice/filter');
            $view->siteData = $siteData;
            $view->data = $data;
            echo Helpers_View::viewToStr($view);
            ?>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1, 'is_group' => '1'));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopinvoice/days')){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/days', array(), array());?>"  data-id="is_public_ignore">Распределенные по дням</a></li>
                    <li class="<?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopinvoice/index') && (Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/index', array(), array('is_public_ignore' => 1, 'is_group' => '1'));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header padding-0">
                        <div>
                            <button data-toggle="modal" data-target="#dialog-edit-period" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить накладную
                            </button>
                        </div>
                    </li>
                    <li class="pull-left header padding-0">
                        <div>
                            <button data-toggle="modal" data-target="#dialog-edit-period-return" class="btn bg-blue btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить возвратную накладную
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/invoice/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
<div id="dialog-edit-period" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить период</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopinvoice/new'); ?>" method="get" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации от
                                </label>
                                <input name="date_from" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(date('d.m.Y')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации до
                                </label>
                                <input name="date_to" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(date('d.m.Y')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary" >Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="dialog-edit-period-return" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить период</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopinvoice/return_new'); ?>" method="get" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации от
                                </label>
                                <input name="date_from" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(date('d.m.Y')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Период реализации до
                                </label>
                                <input name="date_to" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(date('d.m.Y')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary" >Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>
