<!-- Строка  -->
<div class="row record-input record-list">

</div>

<!-- Сохранить при изменении  -->
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

<!-- Сохранить/применить при изменении  -->
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
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

<!-- Вывод чекбокс c галочкой  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<!-- Вывод чекбокс без галочки  -->
<div class="col-md-3 record-title"></div>
<div class="col-md-9">
    <label class="span-checkbox">
        <input name="is_public" value="0" type="checkbox" class="minimal">
        Показать
    </label>
</div>
<!-- Вывод числовых значений  -->
<div class="col-md-3 record-title">
    <label>
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Вес
    </label>
</div>
<div class="col-md-3">
    <input name="weight" type="phone" class="form-control" placeholder="Вес" required>
</div>
<!-- Вывод текстовые значений  -->
<div class="col-md-3 record-title">
    <label>
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Название
    </label>
</div>
<div class="col-md-3">
    <input name="name" type="text" class="form-control" placeholder="Название" required>
</div>
<!-- Вывод даты и временени  -->
<div class="col-md-3 record-title">
    <label>
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Дата создания
    </label>
</div>
<div class="col-md-3">
    <input name="created_at" type="datetime"  date-type="datetime"  class="form-control" placeholder="Дата создания" required>
</div>
<!-- Вывод даты  -->
<div class="col-md-3 record-title">
    <label>
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Дата создания
    </label>
</div>
<div class="col-md-3">
    <input name="created_at" type="datetime"  date-type="date"  class="form-control" placeholder="Дата создания" required>
</div>
<!-- Вывод списка выбора  -->
<div class="col-md-3 record-title">
    <label>
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Вид веса
    </label>
</div>
<div class="col-md-9">
    <select id="daughter_weight_id" name="daughter_weight_id" class="form-control select2" required style="width: 100%;">
        <option value="0" data-id="0">Без значения</option>
        <?php echo $siteData->globalDatas['view::daughter-weight/list/list']; ?>
    </select>
</div>

<!-- Вывод Клиента (списка выбора)  -->
<div class="col-md-3 record-title">
    <label>
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Клиент
    </label>
</div>
<div class="col-md-9">
    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
            id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
    </select>
</div>
<!-- Вывод неизменяемого ввода  -->
disabled - input и select (запрет редактирования + копирования)
readonly - input (запрет редактирования)
required - input и select (обязательное поле)

<!-- Вывод связанной таблицы  -->
<?php echo $siteData->globalDatas['view::_shop/client/contract/item/list/item'];?>

<!-- Вывод print_r  -->
<?php print_r($data->values['options']);?>
