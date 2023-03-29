<div class="row record-input record-list">
    <?php if($siteData->operation->getIsAdmin()){ ?>
    <div class="col-md-3 record-title">
        <label>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'date', ''));?>">
    </div>
    <?php } ?>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Количество рейсов
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="0" name="flight" type="phone" class="form-control"  value="<?php echo Arr::path($data->values, 'flight', '');?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            № машины
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_ballast_car_id" name="shop_ballast_car_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/ballast/car/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Смена
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_work_shift_id" name="shop_work_shift_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/work/shift/list/list']; ?>
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
        <select id="shop_ballast_driver_id" name="shop_ballast_driver_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/ballast/driver/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место погрузки
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_ballast_distance_id" name="shop_ballast_distance_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/ballast/distance/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место выгрузки
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_transportation_place_id" name="shop_transportation_place_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transportation/place/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn bg-green" onclick="$('#is_close').val(0); submitSave('shoptransportation');">Применить</button>
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(1); submitSave('shoptransportation');">Сохранить</button>
    </div>
</div>
<script>
    $('#shop_ballast_car_id').on('change', function() {
        driver = $(this).find('option:selected').data('driver');
        $('#shop_ballast_driver_id').val(driver).trigger('change');
    });
    function submitSave(id) {
        var isError = false;

        var element = $('[name="shop_ballast_car_id"]');
        if ($.trim(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="shop_work_shift_id"]');
        if ($.trim(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="shop_ballast_driver_id"]');
        if ($.trim(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        var element = $('[name="shop_ballast_distance_id"]');
        if ($.trim(element.val()) < 1){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>