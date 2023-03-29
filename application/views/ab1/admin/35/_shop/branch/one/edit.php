<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            ID 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="old_id" type="text" class="form-control" placeholder="ID 1С" required value="<?php echo htmlspecialchars($data->values['old_id'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Вид филила
        </label>
    </div>
    <div class="col-md-9">
        <select name="shop_table_rubric_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Выберите вид филиала</option>
            <?php echo trim($siteData->globalDatas['view::_shop/branch/type/list/list']);?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw"></i></sup>
            Юридическое название
        </label>
    </div>
    <div class="col-md-9">
        <input name="official_name" type="text" class="form-control" placeholder="Юридическое название"  value="<?php echo htmlspecialchars($data->values['official_name'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw"></i></sup>
            БИН
        </label>
    </div>
    <div class="col-md-3">
        <input name="options[requisites][bin]" type="phone" class="form-control" placeholder="БИН" maxlength="12"  value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.bin', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw"></i></sup>
            БИН 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="bin" type="phone" class="form-control" placeholder="БИН 1С" maxlength="12"  value="<?php echo htmlspecialchars($data->values['bin'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № счета
        </label>
    </div>
    <div class="col-md-3">
        <input name="options[requisites][account]" type="text" class="form-control" placeholder="№ счета" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.account', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Банк
        </label>
    </div>
    <div class="col-md-3">
        <select id="bank_id" name="bank_id" class="form-control select2" style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::bank/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Юридический адрес
        </label>
    </div>
    <div class="col-md-9">
        <input name="options[requisites][address]" type="text" class="form-control" placeholder="Юридический адрес" required value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.address', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Должность директора
        </label>
    </div>
    <div class="col-md-3">
        <input name="options[requisites][director_position]" type="text" class="form-control" placeholder="Должность директора" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.director_position', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Действующий на основании
        </label>
    </div>
    <div class="col-md-3">
        <input name="options[requisites][charter]" type="text" class="form-control" placeholder="Действующий на основании" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.charter', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            ФИО директор (сокращенно)
        </label>
    </div>
    <div class="col-md-3">
        <input name="options[requisites][director]" type="text" class="form-control" placeholder="ФИО директор (сокращенно)" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.director', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            ФИО директор (полное)
        </label>
    </div>
    <div class="col-md-3">
        <input name="options[requisites][director_complete]" type="text" class="form-control" placeholder="ФИО директор (полное)" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.director_complete', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Телефоны
        </label>
    </div>
    <div class="col-md-9">
        <input name="options[requisites][phones]" type="text" class="form-control" placeholder="Телефоны" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.phones', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            E-mail
        </label>
    </div>
    <div class="col-md-9">
        <input name="options[requisites][email]" type="text" class="form-control" placeholder="E-mail" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'requisites.email', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            ФИО в отчетах
        </label>
    </div>
    <div class="col-md-9">
        <table class="table table-hover table-db table-tr-line" >
            <tr>
                <th>Название</th>
                <th>Должность</th>
                <th>ФИО</th>
            </tr>
            <tr>
                <td>Директор филиала по производству АБ и КМ</td>
                <td>
                    <input name="options[report][director_branch_product_ab_and_km][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.director_branch_product_ab_and_km.position', 'директор филиала по производству АБ и КМ'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][director_branch_product_ab_and_km][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.director_branch_product_ab_and_km.name', 'Дюсебаев М.У.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Маркшейдер</td>
                <td>
                    <input name="options[report][surveyor][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.surveyor.position', 'маркшейдер'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][surveyor][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.surveyor.name', 'Тулегенов А.Г.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Ведущий инженер лаборатории</td>
                <td>
                    <input name="options[report][leading_engineer_laboratory][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.leading_engineer_laboratory.position', 'ведущий инженер лаборатории'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][leading_engineer_laboratory][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.leading_engineer_laboratory.name', 'Осначук Л.И.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Начальник участка ДСЦ "Южный"</td>
                <td>
                    <input name="options[report][site_manager_dsc_uzhniy][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.site_manager_dsc_uzhniy.position', 'начальник участка ДСЦ "Южный"'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][site_manager_dsc_uzhniy][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.site_manager_dsc_uzhniy.name', 'Шин В.В.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Начальник участка ДСЦ &quot;Северный&quot;</td>
                <td>
                    <input name="options[report][site_manager_dsc_severniy][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.site_manager_dsc_severniy.position', 'начальник участка ДСЦ "Северный"'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][site_manager_dsc_severniy][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.site_manager_dsc_severniy.name', 'Нурманов А.К.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Технический директор</td>
                <td>
                    <input name="options[report][technical_director][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.technical_director.position', 'Технический директор'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][technical_director][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.technical_director.name', 'Супиев К.В.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Директор по производству</td>
                <td>
                    <input name="options[report][production_director][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_director.position', 'Директор по производству'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][production_director][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_director.name', 'Абдуманапов Б.М.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Ст.экон.по бух.учету и анал. хоз.деятельности</td>
                <td>
                    <input name="options[report][senior_accounting_economist][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.senior_accounting_economist.position', 'Ст.экон.по бух.учету и анал. хоз.деятельности'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][senior_accounting_economist][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.senior_accounting_economist.name', 'Нурманова Г.Т.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Инженер производства</td>
                <td>
                    <input name="options[report][production_engineer][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_engineer.position', 'Инженер производства'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][production_engineer][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_engineer.name', 'Битибаева Л.А.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Начальник ПТО</td>
                <td>
                    <input name="options[report][head_of_PTO][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.head_of_PTO.position', 'Начальник ПТО'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][head_of_PTO][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.head_of_PTO.name', 'Абдуманапов Б.М.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Старший механик</td>
                <td>
                    <input name="options[report][chief_engineer][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_engineer.position', 'Старший механик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][chief_engineer][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_engineer.name', 'Ващинин А.А.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Главный механик</td>
                <td>
                    <input name="options[report][chief_mechanical_engineer][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_mechanical_engineer.position', 'Главный механик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][chief_mechanical_engineer][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_mechanical_engineer.name', 'Каримов А.А.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Механик</td>
                <td>
                    <input name="options[report][mechanical_engineer][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.mechanical_engineer.position', 'Механик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>ЗАМ НАЧАЛЬНИКА ПТО</td>
                <td>
                    <input name="options[report][deputy_chief_of_the_PTO][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.deputy_chief_of_the_PTO.position', 'ЗАМ НАЧАЛЬНИКА ПТО'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][deputy_chief_of_the_PTO][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.deputy_chief_of_the_PTO.name', 'Исламов Д.Ш.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>НАЧАЛЬНИК АБиНБ</td>
                <td>
                    <input name="options[report][chief_of_ab_and_nb][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_of_ab_and_nb.position', 'НАЧАЛЬНИК АБиНБ'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][chief_of_ab_and_nb][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_of_ab_and_nb.name', 'Стефанов А.В.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Оператор ТУ НБЦ</td>
                <td>
                    <input name="options[report][operator_of_TU_NBC][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.operator_of_TU_NBC.position', 'Оператор ТУ НБЦ'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Оператор ТУ НБЦ (Бригадир)</td>
                <td>
                    <input name="options[report][operator_of_TU_NBC_foreman][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.operator_of_TU_NBC_foreman.position', 'Оператор ТУ НБЦ (Бригадир)'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Диспетчер ДС и ЖДЦ</td>
                <td>
                    <input name="options[report][dispatcher_DS_and_ZhDC][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.dispatcher_DS_and_ZhDC.position', 'Диспетчер ДС и ЖДЦ'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            </tr>
            <tr>
                <td>Мастер</td>
                <td>
                    <input name="options[report][master][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.master.position', 'Мастер'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Нормировщик</td>
                <td>
                    <input name="options[report][normalizer][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.normalizer.position', 'Нормировщик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Бригадир</td>
                <td>
                    <input name="options[report][foreman][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.foreman.position', 'Бригадир'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Табельщик</td>
                <td>
                    <input name="options[report][timekeeper][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.timekeeper.position', 'Табельщик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Главный технолог</td>
                <td>
                    <input name="options[report][chief_technologist][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_technologist.position', 'Главный технолог'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][chief_technologist][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_technologist.name', 'Стефанова Л.М.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Зам.гл.технолога</td>
                <td>
                    <input name="options[report][deputy_chief_technologist][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.deputy_chief_technologist.position', 'Зам.гл.технолога'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][deputy_chief_technologist][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.deputy_chief_technologist.name', 'Колесникова С.И.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Начальник лаборатории</td>
                <td>
                    <input name="options[report][laboratory_boss][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.laboratory_boss.position', 'Начальник лаборатории'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][laboratory_boss][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.laboratory_boss.name', 'Галимбекова Р.Т.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Начальник производства ЖБИ и БС</td>
                <td>
                    <input name="options[report][production_manager_for_ZhBI_and_BS][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_manager_for_ZhBI_and_BS.position', 'Начальник производства ЖБИ и БС'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][production_manager_for_ZhBI_and_BS][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_manager_for_ZhBI_and_BS.name', 'Джаппаров С.С.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Технолог производства ЖБИ и БС</td>
                <td>
                    <input name="options[report][production_technologist_for_ZhBI_and_BS][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_technologist_for_ZhBI_and_BS.position', 'Технолог производства ЖБИ и БС'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][production_technologist_for_ZhBI_and_BS][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.production_technologist_for_ZhBI_and_BS.name', 'Абдуманапов А.Г.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Главный бухгалтер</td>
                <td>
                    <input name="options[report][chief_accountant][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_accountant.position', 'Главный бухгалтер'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][chief_accountant][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.chief_accountant.name', 'Редих Н.Д.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Начальник АТЦ</td>
                <td>
                    <input name="options[report][head_of_ATC][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.head_of_ATC.position', 'Начальник АТЦ'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][head_of_ATC][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.head_of_ATC.name', 'Меркулов Д.Н.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Дежурный механик</td>
                <td>
                    <input name="options[report][duty_mechanic][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.duty_mechanic.position', 'Дежурный механик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][duty_mechanic][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.duty_mechanic.name', 'Марлинов Я.Т.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Дежурный механик</td>
                <td>
                    <input name="options[report][duty_mechanic_second][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.duty_mechanic_second.position', 'Дежурный механик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][duty_mechanic_second][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.duty_mechanic_second.name', 'Марлинов Я.Т.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Инженер лаборатории</td>
                <td>
                    <input name="options[report][laboratory_engineer][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.laboratory_engineer.position', 'Инженер лаборатории'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][laboratory_engineer][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.laboratory_engineer.name', 'Маметова Ч.М.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Кассир</td>
                <td>
                    <input name="options[report][cashier][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.cashier.position', 'Кассир'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.sales_economist.position', 'экономист по сбыту'), ENT_QUOTES);?></td>
                <td>
                    <input name="options[report][sales_economist][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.sales_economist.position', 'экономист по сбыту'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][sales_economist][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.sales_economist.name', 'Аскаров Д.Р.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Советник Генерального директора</td>
                <td>
                    <input name="options[report][CEOs_councelor][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.CEOs_councelor.position', 'Советник Генерального директора'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][CEOs_councelor][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.CEOs_councelor.name', 'Исламова С.Г.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>И.О.Учетчик (ГСМ)</td>
                <td>
                    <input name="options[report][IO_meter_fuels_and_lubricants][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.IO_meter_fuels_and_lubricants.position', 'И.О.Учетчик (ГСМ)'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
                <td>
                    <input name="options[report][IO_meter_fuels_and_lubricants][name]" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.IO_meter_fuels_and_lubricants.name', 'Курбанов Р.А.'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Таксировщик</td>
                <td>
                    <input name="options[report][taxi_driver][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.taxi_driver.position', 'Таксировщик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Водитель</td>
                <td>
                    <input name="options[report][driver][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.driver.position', 'Водитель'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Диспетчер-нарядчик</td>
                <td>
                    <input name="options[report][dispatcher_commissioner][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.dispatcher_commissioner.position', 'Диспетчер-нарядчик'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
            <tr>
                <td>Начальник эксплуатации</td>
                <td>
                    <input name="options[report][operations_manager][position]" type="text" class="form-control" placeholder="Должность" value="<?php echo htmlspecialchars(Arr::path($data->values['options'], 'report.operations_manager.position', 'Начальник эксплуатации'), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
                </td>
            </tr>
        </table>
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
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
