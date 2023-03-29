<div class="form-group">
    <label class="col-md-2 control-label">
        Дата
    </label>
    <div class="col-md-4">
        <input type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date'], ENT_QUOTES); ?>" readonly>
    </div>
    <label class="col-md-2 control-label">
        Начало
    </label>
    <div class="col-md-4">
        <input type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at'], ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Первая точка
    </label>
    <div class="col-md-10">
        <div class="input-group" style="width: 100%">
            <input  type="text" class="form-control" value="<?php echo htmlspecialchars($data->getElementValue('shop_courier_address_id_from'), ENT_QUOTES); ?>" readonly>
            <?php if ($data->values['shop_courier_address_id_from'] < 1) { ?>
                <span class="input-group-btn">
                    <a data-action="set-work" href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/start_work', array()); ?>" class="btn btn-blue">
                        Начать работу
                    </a>
                </span>
            <?php } ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <b style="font-size: 16px;">Текущая точка</b>
    </label>
    <div class="col-md-10">
        <?php echo $siteData->globalDatas['view::_shop/courier/route/item/list/current']; ?>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <b style="font-size: 16px;">Новые точки</b>
    </label>
    <div class="col-md-10">
        <?php echo $siteData->globalDatas['view::_shop/courier/route/item/list/show']; ?>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <b style="font-size: 16px;">Завершенные точки</b>
    </label>
    <div class="col-md-10">
        <?php echo $siteData->globalDatas['view::_shop/courier/route/item/list/finish']; ?>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <a href="<?php echo Func::getFullURL($siteData, '/shopcourierroute/finish_work', array()); ?>" class="btn bg-green" data-action="set-finish">Завершить</a>
    </div>
</div>
<?php if ($data->values['shop_courier_address_id_from'] < 1) { ?>
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
        <div class="modal-dialog" style="background: #fff;">
            <form method="post" class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    <h4 class="modal-title">Начало работа</h4>
                </div>
                <div class="modal-body" style="margin: 0px 15px;">
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
<?php } ?>
<script>
    $(document).ready(function () {
        var clickButton = undefined;
        $('[data-action="set-finish"]').click(function (e) {
            e.preventDefault();

            var modal = $('#modal-finish');
            modal.modal('show');
            modal.find('form').attr('action', $(this).attr('href'));

            clickButton = $(this);
        });
    });
</script>
<div id="modal-finish" class="modal fade">
    <div class="modal-dialog" style="background: #fff;">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Окончание работа</h4>
            </div>
            <div class="modal-body" style="margin: 0px 15px;">
                <div class="form-group">
                    <label for="modal-courier-shop_courier_address_id">Адрес</label>
                    <select data-type="select2" id="modal-courier-shop_courier_address_id" name="shop_courier_address_id" class="form-control select2" required style="width: 100%;">
                        <?php echo trim($siteData->globalDatas['view::_shop/courier/address/list/list']);?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input name="shop_courier_route_id" value="<?php echo $data->id; ?>" style="display: none">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button data-action="save-courier" type="submit" class="btn btn-primary">Начать</button>
            </div>
        </form>
    </div>
</div>