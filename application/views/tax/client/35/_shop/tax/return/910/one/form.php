<div class="row">
    <h2>УПРОЩЕННАЯ ДЕКЛАРАЦИЯ <br>ДЛЯ СУБЪЕКТОВ МАЛОГО БИЗНЕСА</h2>
    <h3>(Форма 910.00)</h3>
</div>
<div class="row">
    <div class="title-black">Раздел. Исчисление налогов</div>
</div>
<div class="row">
    <div class="number"><input value="910.00.001" class="form-control" type="text" readonly></div>
    <div class="text">Доход</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" data-action="revenue-910" id="<?php echo $formName; ?>-910.00.001" name="options[910.00.001]" value="<?php echo Arr::path($data->values, 'options_910.00.001', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.002" class="form-control" type="text" readonly></div>
    <div class="text">в том числе доход от корректировки в соответствии с Законом о трансфертном ценообразовании</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" id="<?php echo $formName; ?>-910.00.002" name="options[910.00.002]" value="<?php echo Arr::path($data->values, 'options_910.00.002', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.003" class="form-control" type="text" readonly></div>
    <div class="text">Среднесписочная численность работников, в том числе:</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.003" name="options[910.00.003][all]" value="<?php echo Arr::path($data->values, 'options_910.00.003.all', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"></div>
    <div class="text">
        <label class="field-number">A</label>пенсионеры</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.00_a" name="options[910.00.003][a]" value="<?php echo Arr::path($data->values, 'options_910.00.003_a', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"></div>
    <div class="text">
        <label class="field-number">A</label>инвалиды</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.003_b" name="options[910.00.003][b]" value="<?php echo Arr::path($data->values, 'options_910.00.003_b', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.004" class="form-control" type="text" readonly></div>
    <div class="text">Среднемесячная заработная плата на одного работника</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.004" name="options[910.00.004]" value="<?php echo Arr::path($data->values, 'options_910.00.004', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.005" class="form-control" type="text" readonly></div>
    <div class="text">Сумма исчисленных налогов<br>(910.00.001*3%)</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.005" name="options[910.00.005]" value="<?php echo Arr::path($data->values, 'options_910.00.005', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.006" class="form-control" type="text" readonly></div>
    <div class="text">Корректировка суммы налогов в соответствии с пунктом 2 статьи 436 Налогового кодекса</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.006" name="options[910.00.006]" value="<?php echo Arr::path($data->values, 'options_910.00.006', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.007" class="form-control" type="text" readonly></div>
    <div class="text">Сумма налогов после корректировки<br>(910.00.005 - 910.00.006)</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.007" name="options[910.00.007]" value="<?php echo Arr::path($data->values, 'options_910.00.007', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.008" class="form-control" type="text" readonly></div>
    <div class="text">Сумма индивидуального (корпоративного) подоходного налога, <b>подлежащего уплате в бюджет</b> (910.00.007 х 0,5)</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.008" name="options[910.00.008]" value="<?php echo Arr::path($data->values, 'options_910.00.008', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number"><input value="910.00.009" class="form-control" type="text" readonly></div>
    <div class="text">Сумма социального налога, <b>подлежащего уплате в бюджет</b> (910.00.007 х 0,5) - 910.00.011 VII - 910.00.018 VII)</div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.009" name="options[910.00.009]" value="<?php echo Arr::path($data->values, 'options_910.00.009', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="title-black">Раздел. Исчисление социальных отчислений, обязательных пенсионных взносов и взносов на обязательное социальное медицинское страхование за индивидуального предпринимателя</div>
</div>
<!-- 910.00.010 -->
<div class="row">
    <div class="number"><input value="910.00.010" class="form-control" type="text" readonly></div>
    <div class="text">Доход для исчисления социальных отчислений</div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.010_1" name="options[910.00.010][1]" value="<?php echo Arr::path($data->values, 'options_910.00.010_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.010_4" name="options[910.00.010][4]" value="<?php echo Arr::path($data->values, 'options_910.00.010_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.010_2" name="options[910.00.010][2]" value="<?php echo Arr::path($data->values, 'options_910.00.010_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.010_5" name="options[910.00.010][5]" value="<?php echo Arr::path($data->values, 'options_910.00.010_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.010_3" name="options[910.00.010][3]" value="<?php echo Arr::path($data->values, 'options_910.00.010_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.010_6" name="options[910.00.010][6]" value="<?php echo Arr::path($data->values, 'options_910.00.010_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.010_7" name="options[910.00.010][7]" value="<?php echo Arr::path($data->values, 'options_910.00.010_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.011 -->
<div class="row">
    <div class="number"><input value="910.00.011" class="form-control" type="text" readonly></div>
    <div class="text">Сумма социальных отчислений <b>к уплате</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.011_1" name="options[910.00.011][1]" value="<?php echo Arr::path($data->values, 'options_910.00.011_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.011_4" name="options[910.00.011][4]" value="<?php echo Arr::path($data->values, 'options_910.00.011_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.011_2" name="options[910.00.011][2]" value="<?php echo Arr::path($data->values, 'options_910.00.011_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.011_5" name="options[910.00.011][5]" value="<?php echo Arr::path($data->values, 'options_910.00.011_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.011_3" name="options[910.00.011][3]" value="<?php echo Arr::path($data->values, 'options_910.00.011_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.011_6" name="options[910.00.011][6]" value="<?php echo Arr::path($data->values, 'options_910.00.011_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.011_7" name="options[910.00.011][7]" value="<?php echo Arr::path($data->values, 'options_910.00.011_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.012 -->
<div class="row">
    <div class="number"><input value="910.00.012" class="form-control" type="text" readonly></div>
    <div class="text">Доход для исчисления обязательных пенсионных взносов</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.012_1" name="options[910.00.012][1]" value="<?php echo Arr::path($data->values, 'options_910.00.012_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.012_4" name="options[910.00.012][4]" value="<?php echo Arr::path($data->values, 'options_910.00.012_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.012_2" name="options[910.00.012][2]" value="<?php echo Arr::path($data->values, 'options_910.00.012_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.012_5" name="options[910.00.012][5]" value="<?php echo Arr::path($data->values, 'options_910.00.012_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.012_3" name="options[910.00.012][3]" value="<?php echo Arr::path($data->values, 'options_910.00.012_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.012_6" name="options[910.00.012][6]" value="<?php echo Arr::path($data->values, 'options_910.00.012_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.012_7" name="options[910.00.012][7]" value="<?php echo Arr::path($data->values, 'options_910.00.012_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.013 -->
<div class="row">
    <div class="number"><input value="910.00.013" class="form-control" type="text" readonly></div>
    <div class="text">Сумма обязательных пенсионных взносов, <b>к уплате</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.013_1" name="options[910.00.013][1]" value="<?php echo Arr::path($data->values, 'options_910.00.013_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.013_4" name="options[910.00.013][4]" value="<?php echo Arr::path($data->values, 'options_910.00.013_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.013_2" name="options[910.00.013][2]" value="<?php echo Arr::path($data->values, 'options_910.00.013_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.013_5" name="options[910.00.013][5]" value="<?php echo Arr::path($data->values, 'options_910.00.013_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.013_3" name="options[910.00.013][3]" value="<?php echo Arr::path($data->values, 'options_910.00.013_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.013_6" name="options[910.00.013][6]" value="<?php echo Arr::path($data->values, 'options_910.00.013_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.013_7" name="options[910.00.013][7]" value="<?php echo Arr::path($data->values, 'options_910.00.013_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.014 -->
<div class="row">
    <div class="number"><input value="910.00.014" class="form-control" type="text" readonly></div>
    <div class="text">Сумма взносов на обязательное социальное медицинское страхование, <b>к уплате</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.014_1" name="options[910.00.014][1]" value="<?php echo Arr::path($data->values, 'options_910.00.014_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.014_4" name="options[910.00.014][4]" value="<?php echo Arr::path($data->values, 'options_910.00.014_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.014_2" name="options[910.00.014][2]" value="<?php echo Arr::path($data->values, 'options_910.00.014_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.014_5" name="options[910.00.014][5]" value="<?php echo Arr::path($data->values, 'options_910.00.014_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.014_3" name="options[910.00.014][3]" value="<?php echo Arr::path($data->values, 'options_910.00.014_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.014_6" name="options[910.00.014][6]" value="<?php echo Arr::path($data->values, 'options_910.00.01461', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.014_7" name="options[910.00.014][7]" value="<?php echo Arr::path($data->values, 'options_910.00.014_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="title-black">Раздел. Исчисление индивидуального подоходного налога, социальных отчислений, обязательных пенсионных взносов, обязательных процессиональных пенсионных взносов и отчислений на обязательное социальное медицинское страхование физических лиц</div>
</div>
<!-- 910.00.015 -->
<div class="row">
    <div class="number"><input value="910.00.015" class="form-control" type="text" readonly></div>
    <div class="text">Сумма индивидуального подоходного налога, <b>подлежащая перечислению в бюджет</b> с доходов граждан Республики Казахстан</div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.015_1" name="options[910.00.015][1]" value="<?php echo Arr::path($data->values, 'options_910.00.015_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.015_4" name="options[910.00.015][4]" value="<?php echo Arr::path($data->values, 'options_910.00.015_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.015_2" name="options[910.00.015][2]" value="<?php echo Arr::path($data->values, 'options_910.00.015_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.015_5" name="options[910.00.015][5]" value="<?php echo Arr::path($data->values, 'options_910.00.015_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.015_3" name="options[910.00.015][3]" value="<?php echo Arr::path($data->values, 'options_910.00.015_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.015_6" name="options[910.00.015][6]" value="<?php echo Arr::path($data->values, 'options_910.00.015_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.015_7" name="options[910.00.015][7]" value="<?php echo Arr::path($data->values, 'options_910.00.015_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.016 -->
<div class="row">
    <div class="number"><input value="910.00.016" class="form-control" type="text" readonly></div>
    <div class="text">Сумма индивидуального подоходного налога, <b>подлежащая перечислению в бюджет</b> с доходов иностранцев и лиц без гражданства</div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.016_1" name="options[910.00.016][1]" value="<?php echo Arr::path($data->values, 'options_910.00.016_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.016_4" name="options[910.00.016][4]" value="<?php echo Arr::path($data->values, 'options_910.00.016_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.016_2" name="options[910.00.016][2]" value="<?php echo Arr::path($data->values, 'options_910.00.016_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.016_5" name="options[910.00.016][5]" value="<?php echo Arr::path($data->values, 'options_910.00.016_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.016_3" name="options[910.00.016][3]" value="<?php echo Arr::path($data->values, 'options_910.00.016_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.016_6" name="options[910.00.016][6]" value="<?php echo Arr::path($data->values, 'options_910.00.016_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.016_7" name="options[910.00.016][7]" value="<?php echo Arr::path($data->values, 'options_910.00.016_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.017 -->
<div class="row">
    <div class="number"><input value="910.00.017" class="form-control" type="text" readonly></div>
    <div class="text">Доходы физических лиц, с которых исчисляются социальные отчисления</div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.017_1" name="options[910.00.017][1]" value="<?php echo Arr::path($data->values, 'options_910.00.017_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.017_4" name="options[910.00.017][4]" value="<?php echo Arr::path($data->values, 'options_910.00.017_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.017_2" name="options[910.00.017][2]" value="<?php echo Arr::path($data->values, 'options_910.00.017_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.017_5" name="options[910.00.017][5]" value="<?php echo Arr::path($data->values, 'options_910.00.017_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.017_3" name="options[910.00.017][3]" value="<?php echo Arr::path($data->values, 'options_910.00.017_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.017_6" name="options[910.00.017][6]" value="<?php echo Arr::path($data->values, 'options_910.00.017_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.017_7" name="options[910.00.017][7]" value="<?php echo Arr::path($data->values, 'options_910.00.017_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.018 -->
<div class="row">
    <div class="number"><input value="910.00.018" class="form-control" type="text" readonly></div>
    <div class="text">Сумма социальных отчислений, <b>к уплате</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.018_1" name="options[910.00.018][1]" value="<?php echo Arr::path($data->values, 'options_910.00.018_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.018_4" name="options[910.00.018][4]" value="<?php echo Arr::path($data->values, 'options_910.00.018_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.018_2" name="options[910.00.018][2]" value="<?php echo Arr::path($data->values, 'options_910.00.018_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.018_5" name="options[910.00.018][5]" value="<?php echo Arr::path($data->values, 'options_910.00.018_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.018_3" name="options[910.00.018][3]" value="<?php echo Arr::path($data->values, 'options_910.00.018_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.018_6" name="options[910.00.018][6]" value="<?php echo Arr::path($data->values, 'options_910.00.018_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.018_7" name="options[910.00.018][7]" value="<?php echo Arr::path($data->values, 'options_910.00.018_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.019 -->
<div class="row">
    <div class="number"><input value="910.00.019" class="form-control" type="text" readonly></div>
    <div class="text">Доходы работников, с которых удерживаются (начисляются) обязательные пенсионные взносы</div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.019_1" name="options[910.00.019][1]" value="<?php echo Arr::path($data->values, 'options_910.00.019_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.019_4" name="options[910.00.019][4]" value="<?php echo Arr::path($data->values, 'options_910.00.019_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.019_2" name="options[910.00.019][2]" value="<?php echo Arr::path($data->values, 'options_910.00.019_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.019_5" name="options[910.00.019][5]" value="<?php echo Arr::path($data->values, 'options_910.00.019_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.019_3" name="options[910.00.019][3]" value="<?php echo Arr::path($data->values, 'options_910.00.019_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.019_6" name="options[910.00.019][6]" value="<?php echo Arr::path($data->values, 'options_910.00.019_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.019_7" name="options[910.00.019][7]" value="<?php echo Arr::path($data->values, 'options_910.00.019_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.020 -->
<div class="row">
    <div class="number"><input value="910.00.020" class="form-control" type="text" readonly></div>
    <div class="text">Сумма обязательных пенсионных взносов, <b>к уплате</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.020_1" name="options[910.00.020][1]" value="<?php echo Arr::path($data->values, 'options_910.00.020_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.020_4" name="options[910.00.020][4]" value="<?php echo Arr::path($data->values, 'options_910.00.020_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.020_2" name="options[910.00.020][2]" value="<?php echo Arr::path($data->values, 'options_910.00.020_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.020_5" name="options[910.00.020][5]" value="<?php echo Arr::path($data->values, 'options_910.00.020_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.020_3" name="options[910.00.020][3]" value="<?php echo Arr::path($data->values, 'options_910.00.020_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.020_6" name="options[910.00.020][6]" value="<?php echo Arr::path($data->values, 'options_910.00.020_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.020_7" name="options[910.00.020][7]" value="<?php echo Arr::path($data->values, 'options_910.00.020_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.021 -->
<div class="row">
    <div class="number"><input value="910.00.021" class="form-control" type="text" readonly></div>
    <div class="text">Доходы работников, принимаемых для исчисления обязательных профессиональных пенсионных взносов</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.021_1" name="options[910.00.021][1]" value="<?php echo Arr::path($data->values, 'options_910.00.021_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.021_4" name="options[910.00.021][4]" value="<?php echo Arr::path($data->values, 'options_910.00.021_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.021_2" name="options[910.00.021][2]" value="<?php echo Arr::path($data->values, 'options_910.00.021_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.021_5" name="options[910.00.021][5]" value="<?php echo Arr::path($data->values, 'options_910.00.021_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.021_3" name="options[910.00.021][3]" value="<?php echo Arr::path($data->values, 'options_910.00.021_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.021_6" name="options[910.00.021][6]" value="<?php echo Arr::path($data->values, 'options_910.00.021_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.021_7" name="options[910.00.021][7]" value="<?php echo Arr::path($data->values, 'options_910.00.021_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.022 -->
<div class="row">
    <div class="number"><input value="910.00.022" class="form-control" type="text" readonly></div>
    <div class="text">Сумма обязательных профессиональных пенсионных взносов, <b>к уплате</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.022_1" name="options[910.00.022][1]" value="<?php echo Arr::path($data->values, 'options_910.00.022_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.022_4" name="options[910.00.022][4]" value="<?php echo Arr::path($data->values, 'options_910.00.022_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.022_2" name="options[910.00.022][2]" value="<?php echo Arr::path($data->values, 'options_910.00.022_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.022_5" name="options[910.00.022][5]" value="<?php echo Arr::path($data->values, 'options_910.00.022_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.022_3" name="options[910.00.022][3]" value="<?php echo Arr::path($data->values, 'options_910.00.022_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.022_6" name="options[910.00.022][6]" value="<?php echo Arr::path($data->values, 'options_910.00.022_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.022_7" name="options[910.00.022][7]" value="<?php echo Arr::path($data->values, 'options_910.00.022_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.023 -->
<div class="row">
    <div class="number"><input value="910.00.023" class="form-control" type="text" readonly></div>
    <div class="text">Доходы, принимаемые для исчсиления отчислений на обязательное социальное медицинское страхование</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.023_1" name="options[910.00.023][1]" value="<?php echo Arr::path($data->values, 'options_910.00.023_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.023_4" name="options[910.00.023][4]" value="<?php echo Arr::path($data->values, 'options_910.00.023_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.023_2" name="options[910.00.023][2]" value="<?php echo Arr::path($data->values, 'options_910.00.023_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.023_5" name="options[910.00.023][5]" value="<?php echo Arr::path($data->values, 'options_910.00.023_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.023_3" name="options[910.00.023][3]" value="<?php echo Arr::path($data->values, 'options_910.00.023_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.023_6" name="options[910.00.023][6]" value="<?php echo Arr::path($data->values, 'options_910.00.023_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.023_7" name="options[910.00.023][7]" value="<?php echo Arr::path($data->values, 'options_910.00.023_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<!-- 910.00.024 -->
<div class="row">
    <div class="number"><input value="910.00.024" class="form-control" type="text" readonly></div>
    <div class="text">Сумма отчислений на обязательное социальное медицинское страхование, <b>к уплате</b></div>
    <div class="field-right"></div>
</div>
<div class="row">
    <div class="number title">
        1 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">I</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.024_1" name="options[910.00.024][1]" value="<?php echo Arr::path($data->values, 'options_910.00.024_1', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            4 мес
            <label class="field-number">IV</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.024_4" name="options[910.00.024][4]" value="<?php echo Arr::path($data->values, 'options_910.00.024_4', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        2 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">II</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.024_2" name="options[910.00.024][2]" value="<?php echo Arr::path($data->values, 'options_910.00.024_2', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            5 мес
            <label class="field-number">V</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.024_5" name="options[910.00.024][5]" value="<?php echo Arr::path($data->values, 'options_910.00.024_5', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number title">
        3 мес
    </div>
    <div class="text">
        <div class="title-left">
            <label class="field-number">III</label>
            <div class="input-group">
                <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.024_3" name="options[910.00.024][3]" value="<?php echo Arr::path($data->values, 'options_910.00.024_3', '', '_'); ?>">
                <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
            </div>
        </div>
        <div class="title-right">
            6 мес
            <label class="field-number">VI</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly data-action="total-910" id="<?php echo $formName; ?>-910.00.024_6" name="options[910.00.024][6]" value="<?php echo Arr::path($data->values, 'options_910.00.024_6', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="number">
    </div>
    <div class="text">
        <div class="title-right">
            Итого за полугодие
            <label class="field-number">VII</label>
        </div>
    </div>
    <div class="field-right">
        <div class="input-group">
            <input class="form-control money-format" type="text" readonly id="<?php echo $formName; ?>-910.00.024_7" name="options[910.00.024][7]" value="<?php echo Arr::path($data->values, 'options_910.00.024_7', '', '_'); ?>">
            <span class="input-group-addon"><span class="fa fa-info ks-icon"></span></span>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#<?php echo $formName; ?> input[data-action="revenue-910"], input[id="<?php echo $formName; ?>-910.00.011_7"], input[id="<?php echo $formName; ?>-910.00.018_7"]').change(function () {
            var el = $('#<?php echo $formName; ?> input[data-action="revenue-910"]');
            var id = el.attr('id');
            id = id.substring(0, id.length - 1);

            var revenue = Number(el.val());
            if(isNaN(revenue)) {
                revenue = 0;
            }

            var r5 = revenue / 100 * 3;
            $('[id="' + id + 5 + '"]').val(r5);

            var r6 = Number($('[id="' + id + 6 + '"]').val());
            if(isNaN(r6)) {
                r6 = 0;
            }
            var r7 = r5 - r6;
            $('[id="' + id + 7 + '"]').val(r7);

            var r8 = r7/2;
            $('[id="' + id + 8 + '"]').val(r8);

            id = id.substring(0, id.length - 1);
            var r11 = Number($('[id="' + id + 11 + '_7"]').val());
            if(isNaN(r11)) {
                r11 = 0;
            }
            var r18 = Number($('[id="' + id + 18 + '_7"]').val());
            if(isNaN(r18)) {
                r18 = 0;
            }

            var r9 = r8 - r11 - r18;
            $('[id="' + id + '09' + '"]').val(r9);
        });

        $('#<?php echo $formName; ?> input[data-action="total-910"]').change(function () {
            var id = $(this).attr('id');
            id = id.substring(0, id.length - 1);

            var total = 0;
            for(var i = 1; i < 7; i++){
                var tmp = Number($('[id="' + id + i + '"]').val());
                if(!isNaN(tmp)) {
                    total = total + tmp;
                }
            }

            $('[id="' + id + 7 + '"]').val(total).trigger('change');
        });
    });
    $('#<?php echo $formName; ?> .money-format').number(true, 0, '.', ' ');
</script>