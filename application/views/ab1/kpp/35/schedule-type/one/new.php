<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>Название</label>
    </div>
    <div class="col-md-9">
        <input name="name" type="phone" class="form-control" required value="">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>Дней</label>
    </div>
    <div class="col-md-9">
        <input data-type="money" data-fractional-length="0" id="period" name="period" type="phone" class="form-control" placeholder="Период" required value="">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>Расписание</label>
    </div>
    <div class="col-md-9">
        <table class="table table-hover table-db table-tr-line" >
            <tr>
                <th class="text-right">№</th>
                <th class="text-center width-100">Начало</th>
                <th class="text-center width-100">Окончание</th>
                <th class="text-center width-150">Выходной</th>
                <th class="text-center">Специальный день</th>
            </tr>
            <tbody id="schedule">
            <?php if(!empty($data)){ foreach (Arr::path($data->values, 'options', array()) as $key => $option){ ?>
                <tr>
                    <td class="text-right">
                        #
                    </td>
                    <td>
                        <input name="options[<?php echo $key; ?>][from]" type="datetime" date-type="time" class="form-control width-40" placeholder="Начало рабочего дня"  value="" >
                    </td>
                    <td>
                        <input name="options[<?php echo $key; ?>][to]" type="datetime" date-type="time" class="form-control" placeholder="Окончание рабочего дня"  value="" >
                    </td>
                    <td>
                        <label class="span-checkbox">
                            <input name="options[<?php echo $key; ?>][is_free]" value="0" type="checkbox" class="minimal">
                        </label>
                    </td>
                    <td>
                        <label class="span-checkbox">
                            <input name="options[<?php echo $key; ?>][is_special]" value="0" type="checkbox" class="minimal">
                        </label>
                    </td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>
        <div id="new-schedule" data-index="0">
            <!--
            <tr>
                <td data-id="index" class="text-right">
                    #
                </td>
                <td class="text-right width-100">
                    <input name="options[_#index#][from]" type="datetime" date-type="time" class="form-control text-center" placeholder="Начало" value="">
                </td>
                <td class="text-right width-100">
                    <input name="options[_#index#][to]" type="datetime" date-type="time" class="form-control text-center" placeholder="Окончание" value="">
                </td>
                <td class="text-center width-150">
                    <label class="span-checkbox">
                        <input name="options[_#index#][is_free]" value="0" type="checkbox" class="minimal">
                    </label>
                </td>
                <td class="text-center">
                    <label class="span-checkbox">
                        <input name="options[_#index#][is_special]" value="0" type="checkbox" class="minimal">
                    </label>
                </td>
            </tr>
            -->
        </div>
    </div>
</div>

<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    $('#period').change(function (){
        var period = $(this).val();
        period = parseInt(period);
        var n = $('#schedule > *').length + 1;
        for(i = n; i <= period; i++)
        {
            addElement('new-schedule', 'schedule', true);
        }

        for(i = period + 1; i < n; i++)
        {
            $('#schedule > *:last-child').remove();
        }

        for(i = n; i <= period; i++)
        {
            var el = $('#schedule > *:nth-child('+i+') [data-id="index"]');
            el.text(i);
        }
    });
</script>