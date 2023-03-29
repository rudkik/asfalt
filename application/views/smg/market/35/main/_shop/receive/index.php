<div class="tab-content">
    <div class="tab-pane active">
        <?php $siteData->titleTop = 'Закуп товаров';?>
        <?php $view = View::factory('smg/market/35/main/_shop/receive/filter/index');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);?>
    </div>
        <div class="nav-tabs-custom" style="margin-bottom: 0px;">
            <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index', array(), array('is_not_public' => 1));?>" data-id="is_not_public">Неактивные</a></li>
                <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopreceive/index', array(), array('is_public' => 1));?>" data-id="is_public">Активные</a></li>
                <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';} ?>"><a href=" <?php echo Func::getFullURL($siteData, '/shopreceive/index', array(), array('is_public_ignore' => 1)); ?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class="pull-left header">
                    <span style="margin-right: 10px">
                        <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/new', array()); ?>" class="btn btn-violet">
                            <i class="fa fa-fw fa-plus"></i>
                            Добавить
                        </a>
                    </span>
                </li>
                <li class="pull-left header">
                    <div class="btn-group" style="margin-right: 10px">
                        <button type="button" class="btn btn-success">Считать из файла</button>
                        <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a data-action="load-file" data-title="ЭСФ" href="<?php echo Func::getFullURL($siteData, '/shopreceive/load_esf');?>">Считать ЭСФ</a></li>
                        </ul>
                    </div>
                </li>
                <li class="pull-left header">
                    <span style="margin-right: 10px">
                        <a href="<?php echo Func::getFullURL($siteData, '/shopreceive/check', array()); ?>" class="btn btn-blue">
                            Сделать проверку
                        </a>
                    </span>
                </li>
            </ul>
        </div>
    <div class="body-table">
        <div class="box-body table-responsive" style="padding-top: 0px;">
            <?php echo trim($data['view::_shop/receive/list/index']); ?>
        </div>
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
                    <label>Файл ЭСФ xml</label>
                    <div class="file-upload" data-text="Выберите файл">
                        <input type="file" name="file[]" multiple="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button type="submit" class="btn btn-primary">Считать</button>
            </div>
        </form>
    </div>
</div>