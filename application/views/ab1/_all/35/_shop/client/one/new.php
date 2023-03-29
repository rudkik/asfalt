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
            <div class="col-md-3 record-title"></div>
            <div class="col-md-9">
                <label class="span-checkbox">
                    <input name="is_public" value="0" style="display: none">
                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                    Показать
                </label>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название
                </label>
            </div>
            <div class="col-md-3">
                <input data-unique="true" data-field="name_full" data-href="/sbyt/shopclient/json" data-message="Такое название уже есть в базе данных" name="name" type="text" class="form-control" placeholder="Название" required>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Вид клиента
                </label>
            </div>
            <div class="col-md-3">
                <select id="client_type_id" name="client_type_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::client-type/list/list']; ?>
                </select>
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
                <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название на сайте
                </label>
            </div>
            <div class="col-md-3">
                <input name="name_site" type="text" class="form-control" placeholder="Название на сайте">
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
                <input name="name_complete" type="text" class="form-control" placeholder="Полное название">
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
                <select id="organization_type_id" name="organization_type_id" class="form-control select2" style="width: 100%;" required>
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
                <select id="kato_id" name="kato_id" class="form-control select2" style="width: 100%;">
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
                <input data-unique="true" data-field="bin_full" data-href="/sbyt/shopclient/json" data-message="Такой БИН/ИИН уже есть в базе данных" maxlength="12" name="bin" type="text" class="form-control" placeholder="БИН/ИИН">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    Мобильный телефон
                </label>
            </div>
            <div class="col-md-3">
                <input data-type="mobile"  data-unique="true" data-field="mobile_full" data-href="/sbyt/shopclient/json" data-message="Такой мобильный телефон уже есть в базе данных" maxlength="23" name="mobile" type="text" class="form-control" placeholder="Мобильный телефон">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Адрес
                </label>
            </div>
            <div class="col-md-9">
                <textarea rows="1" name="address" type="text" class="form-control" placeholder="Адрес"></textarea>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    № счета
                </label>
            </div>
            <div class="col-md-3">
                <input name="account" type="text" class="form-control" placeholder="№ счета">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    Банк
                </label>
            </div>
            <div class="col-md-3">
                <select id="bank_id" name="bank_id" class="form-control select2" style="width: 100%;">
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
                <input name="director_position" type="text" class="form-control" placeholder="Должность директора">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    Действующий на основании
                </label>
            </div>
            <div class="col-md-3">
                <input name="charter" type="text" class="form-control" placeholder="Действующий на основании">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    ФИО директор (сокращенно)
                </label>
            </div>
            <div class="col-md-3">
                <input name="director" type="text" class="form-control" placeholder="ФИО директор (сокращенно)">
            </div>
            <div class="col-md-3 record-title">
                <label>
                    ФИО директор (полное)
                </label>
            </div>
            <div class="col-md-3">
                <input name="director_complete" type="text" class="form-control" placeholder="ФИО директор (полное)">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Свидетельство о государственной регистрации
                </label>
            </div>
            <div class="col-md-9">
                <textarea rows="2" name="contact_person" type="text" class="form-control" placeholder="Свидетельство о государственной регистрации"></textarea>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Телефоны
                </label>
            </div>
            <div class="col-md-9">
                <input name="phones" type="text" class="form-control" placeholder="Телефоны">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    E-mail
                </label>
            </div>
            <div class="col-md-9">
                <input name="email" type="text" class="form-control" placeholder="E-mail">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Контактное лицо
                </label>
            </div>
            <div class="col-md-9">
                <textarea rows="5" name="contact_person" type="text" class="form-control" placeholder="Контактное лицо"></textarea>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Примечание
                </label>
            </div>
            <div class="col-md-9">
                <textarea rows="5" name="text" type="text" class="form-control" placeholder="Примечание"></textarea>
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
                        <?php echo $siteData->globalDatas['view::client-type/list/list']; ?>
                    </select>
                </div>
            </div>
        </div>
        <?php if(Request_RequestParams::getParamInt('client_type_id') == Model_Ab1_ClientType::CLIENT_TYPE_LESSEE){ ?>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        Процент за хранение
                    </label>
                </div>
                <div class="col-md-3">
                    <input data-type="money" data-fractional-length="2" name="options[lessee_percent]" type="text" class="form-control" placeholder="Процент за хранение">
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
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

