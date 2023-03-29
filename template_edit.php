<!-- Строка  -->
<div class="row record-input record-list">

</div>

<!-- Вывод Клиента (списка выбора)  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo $data->values['shop_client_id'];?>"
                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
        </select>
    </div>
</div>

<!-- Вывод списка выбора  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сотрудник
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
</div>

<!-- Вывод числовых значений  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Вес
        </label>
    </div>
    <div class="col-md-3">
        <input name="weight" type="phone" class="form-control" placeholder="Вес" required value="<?php echo $data->values['weight'];?>">
    </div>
</div>

<!-- Вывод текстовые значений  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-3">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>

<!-- Вывод даты и временени  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата создания
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime"  date-type="datetime"  class="form-control" placeholder="Дата исследования" required value="<?php echo Helpers_DateTime::getDateTimeFormatRus('date'); ?>">
    </div>
</div>

<!-- Вывод даты  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата создания
        </label>
    </div>
    <div class="col-md-3">
        <input name="created_at" type="datetime"  date-type="date"  class="form-control" placeholder="Дата создания" required value="<?php echo Helpers_DateTime::getDateFormatRus('date'); ?>">
    </div>
</div>

<!-- Вывод чекбокс Показать -->
<div class="col-md-3 record-title"></div>
<div class="col-md-9">
    <label class="span-checkbox">
        <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        Показать
    </label>
</div>
<!-- Вывод чекбокс  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Точки входа/въезда сотрудников
        </label>
    </div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_car" <?php if ($data->values['is_car'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        </label>
    </div>
</div>

<!-- Сохранить при изменении  -->
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

<!-- Сохранить/применить при изменении  -->
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
    function submitSave(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>

<!-- Вывод неизменяемого ввода  -->
disabled - input и select
readonly - input

