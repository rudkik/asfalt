<div class="tab-content">
    <div class="tab-pane active">
        <?php $siteData->titleTop = 'Маршруты курьеров';?>
        <?php $view = View::factory('smg/market/35/main/_shop/courier/route/filter/courier');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);?>
    </div>
    <div class="nav-tabs-custom" style="margin-bottom: 0px;">
        <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
            <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';} ?>"><a href=" <?php echo Func::getFullURL($siteData, '/shopcourierroute/index', array(), array('is_public_ignore' => 1)); ?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
            <li class="pull-left header">
                <span>
                    <a data-action="set-work" href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/start_work', array()); ?>" class="btn btn-blue">
                        Начать работу
                    </a>
                </span>
            </li>
        </ul>
    </div>
    <div class="body-table">
        <div class="box-body table-responsive" style="padding-top: 0px;">
            <?php echo trim($data['view::_shop/courier/route/list/courier']); ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var clickButton = undefined;
        $('[data-action="set-work"]').click(function (e) {
            e.preventDefault();

            var modal = $('#modal-work');
            modal.modal('show');
            modal.find('form').attr('action', $(this).attr('href'));

            clickButton = $(this);
        });
    });
</script>
<div id="modal-work" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Начало работа</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal-courier-shop_courier_address_id">Адрес</label>
                    <select data-type="select2" id="modal-courier-shop_courier_address_id" name="shop_courier_address_id" class="form-control select2" required style="width: 100%;">
                        <?php echo trim($siteData->globalDatas['view::_shop/courier/address/list/list']);?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-courier" type="submit" class="btn btn-primary">Начать</button>
            </div>
        </form>
    </div>
</div>

