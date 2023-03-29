<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-3">
        <input name="name" type="text" class="form-control" placeholder="Название" required >
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Идентификатор
        </label>
    </div>
    <div class="col-md-3">
        <input name="identifier" type="text" class="form-control" placeholder="Идентификатор" required >
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_show_document_indicator" value="0" style="display: none;">
            <input name="is_show_document_indicator" value="1" checked type="checkbox" class="minimal">
            Отображать показатель в документе расчета
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_expense_fuel" value="0" style="display: none;">
            <input name="is_expense_fuel" value="1" checked type="checkbox" class="minimal">
            Является показателем расчета нормы расхода ГСМ
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_calc_wage" value="0" style="display: none;">
            <input name="is_calc_wage" value="1" checked type="checkbox" class="minimal">
            Является показателем расчета заработной платы
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_calc_work_time" value="0" style="display: none;">
            <input name="is_calc_work_time" value="0" type="checkbox" class="minimal">
            Засчитывается как отработанное время
        </label><br>
        <span>Значение показателя будет использоваться для определения количества отработанных дней и часов</span>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <h3 class="text-blue" style="margin: 15px 0px 5px;">Автозаполнение</h3>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label>
            <input type="radio" name="autocomplete_type_id" value="1" data-id="1" checked class="minimal">
            Из сведений о транспортном средстве
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label style="margin-top: 7px;">
            <input type="radio" name="autocomplete_type_id" value="2" data-id="2" class="minimal">
            По параметру выработки
        </label>
    </div>
    <div class="col-md-3 record-title">
        <label>Параметр выработки</label>
    </div>
    <div class="col-md-3">
        <select id="shop_transport_work_id" name="shop_transport_work_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/work/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label>
            <input type="radio" name="autocomplete_type_id" value="3" data-id="3" class="minimal">
            По данным кадрого учета
        </label>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

<script>
    $('[name="autocomplete_type_id"]').on('ifChecked', function (event) {
        if($(this).val() == 2){
            $('#shop_transport_work_id').removeAttr('disabled');
        }else{
            $('#shop_transport_work_id').attr('disabled', '');
        }
    }).trigger('ifChecked');
</script>