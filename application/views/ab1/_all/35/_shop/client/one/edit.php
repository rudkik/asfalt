<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link active" data-toggle="tab" href="#description">
            Данные клиента
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-files">
            Сканы документов
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade active in" id="description" style="padding-top: 20px;">
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
    </div>
    <div class="col-md-9">
        <h4 class="text-blue">
            <span>Остатки на 01.01.2020</span>
        </h4>
    </div>
</div>
<?php if($siteData->operation->getIsAdmin() || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_SBYT){ ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Наличные
        </label>
    </div>
    <div class="col-md-3">
        <input name="amount_cash_1c" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values, 'amount_cash_1c', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Общий баланс
        </label>
    </div>
    <div class="col-md-3">
        <input name="amount_1c" type="text" class="form-control"  value="<?php echo htmlspecialchars(Arr::path($data->values, 'amount_1c', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<?php } ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
            Показать
        </label>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Вид клиента
        </label>
    </div>
    <div class="col-md-3">
        <select id="client_type_id" name="client_type_id" class="form-control select2" style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::client-type/list/list']; ?>
        </select>
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
        <input data-unique="true" data-field="name_full" data-href="/sbyt/shopclient/json?id_not=<?php echo $data->id;?>" data-message="Такое название уже есть в базе данных" name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_1c', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название на сайте
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_site" type="text" class="form-control" placeholder="Название на сайте" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_site', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Полное название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name_complete" type="text" class="form-control" placeholder="Полное название" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_complete', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Тип организации
        </label>
    </div>
    <div class="col-md-3">
        <select id="organization_type_id" name="organization_type_id" class="form-control select2" style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?> required>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::organizationtype/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            КАТО
        </label>
    </div>
    <div class="col-md-3">
        <select id="kato_id" name="kato_id" class="form-control select2" style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::kato/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            БИН/ИИН
        </label>
    </div>
    <div class="col-md-3">
        <input data-unique="true" data-field="bin_full" data-href="/sbyt/shopclient/json?id_not=<?php echo $data->id;?>" data-message="Данный БИН/ИИН уже существует" maxlength="12" name="bin" type="text" class="form-control" placeholder="БИН/ИИН" value="<?php echo htmlspecialchars(Arr::path($data->values, 'bin', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Мобильный телефон
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="mobile"  data-unique="true" data-field="mobile_full" data-href="/sbyt/shopclient/json" data-message="Такой мобильный телефон уже есть в базе данных" maxlength="23" name="mobile" type="text" class="form-control" placeholder="Мобильный телефон" value="<?php echo htmlspecialchars(Arr::path($data->values, 'mobile', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Адрес
        </label>
    </div>
    <div class="col-md-9">
        <textarea rows="1" name="address" type="text" class="form-control" placeholder="Адрес" <?php if($isShow){ ?>readonly<?php } ?>><?php echo htmlspecialchars(Arr::path($data->values, 'address', ''), ENT_QUOTES);?></textarea>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № счета
        </label>
    </div>
    <div class="col-md-3">
        <input name="account" type="text" class="form-control" placeholder="№ счета" value="<?php echo htmlspecialchars(Arr::path($data->values, 'account', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
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
            Должность директора
        </label>
    </div>
    <div class="col-md-3">
        <input name="director_position" type="text" class="form-control" placeholder="Должность директора" value="<?php echo htmlspecialchars(Arr::path($data->values, 'director_position', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Действующий на основании
        </label>
    </div>
    <div class="col-md-3">
        <input name="charter" type="text" class="form-control" placeholder="Действующий на основании" value="<?php echo htmlspecialchars(Arr::path($data->values, 'charter', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            ФИО директор (сокращенно)
        </label>
    </div>
    <div class="col-md-3">
        <input name="director" type="text" class="form-control" placeholder="ФИО директор (сокращенно)" value="<?php echo htmlspecialchars(Arr::path($data->values, 'director', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
    <div class="col-md-3 record-title">
        <label>
            ФИО директор (полное)
        </label>
    </div>
    <div class="col-md-3">
        <input name="director_complete" type="text" class="form-control" placeholder="ФИО директор (полное)" value="<?php echo htmlspecialchars(Arr::path($data->values, 'director_complete', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Свидетельство о государственной регистрации
            </label>
        </div>
        <div class="col-md-9">
            <textarea rows="2" name="contact_person" type="text" class="form-control" placeholder="Свидетельство о государственной регистрации" <?php if($isShow){ ?>readonly<?php } ?>><?php echo htmlspecialchars(Arr::path($data->values, 'state_certificate', ''), ENT_QUOTES);?></textarea>
        </div>
    </div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Телефоны
        </label>
    </div>
    <div class="col-md-9">
        <input name="phones" type="text" class="form-control" placeholder="Телефоны" value="<?php echo htmlspecialchars(Arr::path($data->values, 'phones', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            E-mail
        </label>
    </div>
    <div class="col-md-9">
        <input name="email" type="text" class="form-control" placeholder="E-mail" value="<?php echo htmlspecialchars(Arr::path($data->values, 'email', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </div>
</div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Контактное лицо
            </label>
        </div>
        <div class="col-md-9">
            <textarea rows="5" name="contact_person" type="text" class="form-control" placeholder="Контактное лицо" <?php if($isShow){ ?>readonly<?php } ?>><?php echo htmlspecialchars(Arr::path($data->values, 'contact_person', ''), ENT_QUOTES);?></textarea>
        </div>
    </div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea rows="5" name="text" type="text" class="form-control" placeholder="Примечание" <?php if($isShow){ ?>readonly<?php } ?>><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Виды клиента
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="client_type_ids" name="client_type_ids[]" class="form-control select2" multiple required style="width: 100%;">
                <?php echo $siteData->globalDatas['view::client-type/list/list-list']; ?>
            </select>
        </div>
    </div>
</div>
<?php if($data->values['client_type_id'] == Model_Ab1_ClientType::CLIENT_TYPE_LESSEE){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Процент за хранение
            </label>
        </div>
        <div class="col-md-3">
            <input data-type="money" data-fractional-length="2" name="options[lessee_percent]" type="text" class="form-control" placeholder="Процент за хранение" value="<?php echo htmlspecialchars(Arr::path($data->values, 'options.lessee_percent', ''), ENT_QUOTES);?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
    </div>
<?php } ?>

<?php if($siteData->operation->getIsAdmin() || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_PTO){ ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
        </div>
        <div class="col-md-9">
            <h4 class="text-blue">
                <span>Платежный календарь</span>
            </h4>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title"></div>
        <div class="col-md-9">
            <label class="span-checkbox">
                <input name="is_lawsuit" value="0" style="display: none">
                <input name="is_lawsuit" <?php if (Arr::path($data->values, 'is_lawsuit', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" <?php if($isShow){ ?>disabled<?php } ?>>
                Судебная/претензионная работа
            </label>
        </div>
    </div>
<?php } ?>
<?php if(!$isShow){ ?>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <input name="client_type_id" value="<?php echo Arr::path($data->values, 'client_type_id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
<?php } ?>


    </div>
    <div class="tab-pane fade" id="tab-files" style="padding-top: 20px;">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Файл
                </label>
            </div>
            <div class="col-md-9">
                <input name="options[files][]" value="" style="display: none">
                <table class="table table-hover table-db table-tr-line" >
                    <tr>
                        <th>Файлы</th>
                        <th class="width-90"></th>
                    </tr>
                    <tbody id="files">
                    <?php
                    $i = -1;
                    foreach (Arr::path($data->values['options'], 'files', array()) as $file){
                        $i++;
                        if(empty($file)){
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>"><?php echo Arr::path($file, 'name', ''); ?></a>
                                <input name="options[files][<?php echo $i; ?>][file]" value="<?php echo Arr::path($file, 'file', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][name]" value="<?php echo Arr::path($file, 'name', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][size]" value="<?php echo Arr::path($file, 'size', ''); ?>" style="display: none">
                            </td>
                            <td>
                                <ul class="list-inline tr-button ">
                                    <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-file', 'files', true);">Добавить файл</button>
                </div>
                <div id="new-file" data-index="0">
                    <!--
                    <tr>
                        <td>
                            <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                                <input type="file" name="options[files][_#index#]" >
                            </div>
                        </td>
                        <td>
                            <ul class="list-inline tr-button delete">
                                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                            </ul>
                        </td>
                    </tr>
                    -->
                </div>
                <div>
                    <b>Примечание</b><br>
                    Учредительные документов (устав, приказы и т.д.)
                </div>
            </div>
        </div>
    </div>
</div>
