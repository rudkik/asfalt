<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Номер
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Номер" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES); ?>" <?php if($isShow){?>readonly<?php }?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input id="date" name="date" type="datetime"  date-type="date"  class="form-control" placeholder="Дата" required value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" <?php if($isShow){?>readonly<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Дата начала ремонта
        </label>
    </div>
    <div class="col-md-3">
        <input data-action="hours" name="from_at" type="datetime"  date-type="datetime"  class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?>" <?php if($isShow){?>readonly<?php }?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Дата окончания ремонта
        </label>
    </div>
    <div class="col-md-3">
        <input data-action="hours" name="to_at" type="datetime"  date-type="datetime"  class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?>" <?php if($isShow){?>readonly<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Часов ремонта
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="0" name="hours" type="text" class="form-control" placeholder="Часов ремонта" value="<?php echo htmlspecialchars($data->values['hours'], ENT_QUOTES); ?>" <?php if($isShow){?>readonly<?php }?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Транспортное средство
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_transport_id" name="shop_transport_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Подразделение
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_subdivision_id" name="shop_subdivision_id" class="form-control select2"  style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/subdivision/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Водитель
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_transport_driver_id" name="shop_transport_driver_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/driver/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <a class="btn bg-green pull-left margin-l-10" href="<?php echo Func::getFullURL($siteData, '/shopreport/transport_repair', array('id' => 'id')); ?>">Печать итогов</a>

        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/Datejs/build/date.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/_component/Datejs/build/date-ru-RU.js"></script>
<script>
    $(document).ready(function () {
        $('[data-action="hours"]').change(function () {
            jQuery.ajax({
                url: '/ab1/func/diff_hours',
                data: ({
                    'date_from': ($('[name="from_at"]').val()),
                    'date_to': ($('[name="to_at"]').val()),
                    'is_dinner': (true)
                }),
                type: "GET",
                success: function (data) {
                    $('[name="hours"]').val(data);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        // дата
        $('[name="date"]').change(function () {
            var date = $(this).val();

            var element = $('[name="from_at"]');
            var s = element.val();
            if(s != '') {
                element.val(date + s.substring(10, 16));
            }
            element.trigger('change');
        });

        $('#date, #shop_transport_driver_id').change(function () {
            var date = $('#date').val();
            var driver = $('#shop_transport_driver_id').val();
            if(date == '' || driver < 1){
                $('#date').parent().removeClass('has-error');
                $('#shop_transport_driver_id').parent().removeClass('has-error');
                return false;
            }

            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName; ?>/shoptransportrepair/json',
                data: ({
                    'date': (date),
                    'shop_transport_driver_id': (driver),
                    'id_not': (<?php echo  $data->id; ?>),
                    'limit': (1),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    if(obj.length > 0){
                        $('#date').parent().addClass('has-error');
                        $('#shop_transport_driver_id').parent().addClass('has-error');

                        addMessageBox('Водитель уже занят ремонтом в выбранный день.');
                    }else{
                        $('#date').parent().removeClass('has-error');
                        $('#shop_transport_driver_id').parent().removeClass('has-error');

                        delMessageBox();
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    });
</script>