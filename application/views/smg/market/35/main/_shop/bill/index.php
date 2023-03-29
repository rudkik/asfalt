<div class="tab-pane active">
    <?php $siteData->titleTop = 'Заказы'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/bill/filter/index');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index', array(), array('is_not_public' => 1));?>" data-id="is_not_public">Неактивные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index', array(), array('is_public' => 1));?>" data-id="is_public">Активные</a></li>
        <li class="<?php if(($siteData->url != '/'.$siteData->actionURLName.'/shopbill/index_edit') && ($siteData->url != '/'.$siteData->actionURLName.'/shopbill/sort') && (Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
        <li class="pull-left header">
            <span>
                <a href="<?php echo Func::getFullURL($siteData, '/shopbill/new', array());?>" class="btn btn-violet">
                    <i class="fa fa-fw fa-plus"></i>
                    Добавить
                </a>
            </span>
        </li>
        <li class="pull-left header">
            <div class="btn-group" style="margin-right: 10px">
                <button type="button" class="btn btn-success">Считать с сайта</button>
                <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="<?php echo $siteData->urlBasic . '/smg/kaspi/check_bills' . URL::query(['shop_source_id' => 1, 'shop_branch_id' => $siteData->shopID, 'url' => '/market/shopbill/index']);?>">Kaspi</a></li>
                </ul>
            </div>
        </li>
        <li class="pull-left header">
            <div class="btn-group" style="margin-right: 10px">
                <button type="button" class="btn btn-success">Считать из Excel</button>
                <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a data-action="load-file" data-title="Kaspi" href="<?php echo Func::getFullURL($siteData, '/shopbill/load_kaspi');?>">Считать для Kaspi</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/bill/list/index']); ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        var clickButton = undefined;
        $('[data-action="load-file"]').click(function (e) {
            e.preventDefault();
            var modal = $('#modal-file');
            modal.modal('show');

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('h4.text-blue').text($(this).data('title'));

            clickButton = $(this);
        });
    });
</script>
<div id="modal-file" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Выберите файл</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;"></h4>
                <div class="form-group">
                    <label for="modal-status-shop_bank_account_id">№ счета</label>
                    <select data-type="select2" id="modal-shop_bank_account_id" name="shop_bank_account_id" class="form-control select2" required style="width: 100%;">
                        <option value="-1" data-id="-1">Выберите значение</option>
                        <?php echo trim($siteData->replaceDatas['view::_shop/bank/account/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="modal-status-shop_company_id">Компания</label>
                    <select data-type="select2" id="modal-shop_company_id" name="shop_company_id" class="form-control select2" required style="width: 100%;">
                        <option value="-1" data-id="-1">Выберите значение</option>
                        <?php echo trim($siteData->replaceDatas['view::_shop/company/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Файл из банка</label>
                    <div class="file-upload" data-text="Выберите файл">
                        <input type="file" name="file" multiple="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="first_row">С какой строки начать считывания</label>
                    <input name="first_row" type="text" class="form-control" placeholder="С какой строки начать считывания" value="8" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button type="submit" class="btn btn-primary">Считать</button>
            </div>
        </form>
    </div>
</div>
