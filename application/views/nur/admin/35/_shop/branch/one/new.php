<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Базовая информация</h5>
            </div>
            <div class="card-block">
                <div class="form-group ">
                    <label class="span-checkbox">
                        <input name="is_public" value="1" checked type="checkbox" class="minimal">
                        Активный клиент
                    </label>
                </div>
                <div class="form-group">
                    <label for="shop_bookkeeper_id" class="block">Какой бухгалтер ведет?</label>
                    <select name="shop_bookkeeper_id" id="shop_bookkeeper_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                        <option value="0">Выберите банк</option>
                        <?php echo $siteData->globalDatas['view::_shop/operation/list/list']; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="requisites-organization_type_id" class="block">Правовая форма</label>
                    <select name="requisites[organization_type_id]" id="requisites-organization_type_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::organizationtype/list/list']; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="requisites-organization_tax_type_id" class="block">Налоговый режим</label>
                    <select name="requisites[organization_tax_type_id]" id="requisites-organization_tax_type_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::organizationtaxtype/list/list']; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="options-shop_group_task_ids" class="block">Список задач</label>
                    <select name="requisites[shop_group_task_ids][]" id="shop_group_task_ids" class="js-example-basic-multiple" data-type="select2" multiple="multiple" style="width: 100%">
                        <?php echo $siteData->globalDatas['view::_shop/task/group/list/list']; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>НДС</h5>
            </div>
            <div class="card-block">
                <div class="form-group">
                    <label for="requisites-nds_number" class="block">Номер документа</label>
                    <input id="requisites-nds_number" name="requisites[nds_number]" type="text" class="form-control" placeholder="Номер документа">
                </div>
                <div class="form-group">
                    <label for="requisites-nds_series" class="block">Серия</label>
                    <input id="requisites-nds_series" name="requisites[nds_series]" type="text" class="form-control" placeholder="Серия">
                </div>
                <div class="form-group">
                    <label for="requisites-nds_date" class="block">Дата постановки на учет</label>
                    <input id="requisites-nds_date" name="requisites[nds_date]" type="datetime" data-type="date" class="form-control" placeholder="Дата">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Реквизиты</h5>
            </div>
            <div class="card-block">
                <div class="form-group">
                    <label for="name" class="block">Название</label>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Название" required>
                </div>
                <div class="form-group">
                    <label for="requisites-bin" class="block">БИН</label>
                    <input data-format="999999999999" id="requisites-bin" name="requisites[bin]" type="text" class="form-control" placeholder="БИН" required>
                </div>
                <div class="form-group">
                    <label for="requisites-account" class="block">Банковский счет</label>
                    <input id="requisites-account" name="requisites[account]" type="text" class="form-control" placeholder="Банковский счет" required>
                </div>
                <div class="form-group">
                    <label for="requisites-bank_id" class="block">Банк</label>
                    <select id="requisites-bank_id" name="requisites[bank_id]" class="js-example-basic-single" data-type="select2" style="width: 100%">
                        <option value="0">Выберите банк</option>
                        <?php echo $siteData->globalDatas['view::bank/list/list']; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="requisites-director" class="block">ФИО директора</label>
                    <input id="requisites-director" name="requisites[director]" type="text" class="form-control" placeholder="ФИО директора">
                </div>
                <div class="form-group">
                    <label for="requisites-director_iin" class="block">ИИН директора</label>
                    <input data-format="999999999999" id="requisites-director_iin" name="requisites[director_iin]" type="text" class="form-control" placeholder="ИИН директора">
                </div>
                <div class="form-group">
                    <label for="requisites-director_post" class="block">Должность директора</label>
                    <input id="requisites-director_post" name="requisites[director_post]" type="text" class="form-control" placeholder="Должность директора" value="директор">
                </div>
                <div class="form-group">
                    <label for="requisites-address" class="block">Юридический адрес</label>
                    <textarea id="requisites-address" name="requisites[address]" class="form-control" placeholder="Юридический адрес"></textarea>
                </div>
                <div class="form-group">
                    <label for="requisites-address-actual" class="block">Фактический адрес</label>
                    <textarea id="requisites-address-actual" name="requisites[address_actual]" class="form-control" placeholder="Фактический адрес"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>О компании</h5>
            </div>
            <div class="card-block">
                <div class="form-group">
                    <label for="requisites-created_at" class="block">Дата регистраций</label>
                    <input id="requisites-created_at" name="requisites[created_at]" type="datetime" data-type="date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="requisites-company_number" class="block">№ государственного реестра</label>
                    <input id="requisites-company_number" name="requisites[company_number]" type="text" placeholder="№ государственного реестр" class="form-control">
                </div>
                <div class="form-group">
                    <label for="requisites-nominal_capital" class="block">Уставной капитал</label>
                    <input id="requisites-nominal_capital" name="requisites[nominal_capital]" type="text" placeholder="Уставной капитал" class="form-control">
                </div>
                <div class="form-group">
                    <label for="requisites-shop_company_view_id" class="block">Вид деятельности</label>
                    <select name="requisites[shop_company_view_id]" id="requisites-shop_company_view_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/company/view/list/list']; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="requisites-authority_id" class="block">Код налогового органа</label>
                    <select name="requisites[authority_id]" id="requisites-authority_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::authority/list/list']; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="requisites-akimat_id" class="block">БИН аппарата акимов</label>
                    <select name="requisites[akimat_id]" id="requisites-akimat_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::akimat/list/list']; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>ЭЦФ</h5>
            </div>
            <div class="card-block">
                <div class="form-group">
                    <label for="ecf-file_auth" class="block">Файл авторизации (AUTH_*)</label>
                    <div class="file-upload" data-text="Выберите файл">
                        <input id="ecf-file_auth" type="file" name="ecf[auth][file]" data-file-upload="1">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ecf-auth_password" class="block">Пароль</label>
                    <input id="ecf-auth_password" name="ecf[auth][password]" type="password" class="form-control" placeholder="Пароль">
                </div>
                <div class="form-group">
                    <label for="ecf-auth_date_finish" class="block">Срок действия</label>
                    <input id="ecf-auth_date_finish" name="ecf[auth][date_finish]" type="datetime" data-type="date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="ecf-file_gostknca" class="block">Файл подписи (GOSTKNCA_*)</label>
                    <div class="file-upload" data-text="Выберите файл">
                        <input id="ecf-file_gostknca" type="file" name="ecf[gostknca][file]" data-file-upload="1">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ecf-gostknca_password" class="block">Пароль</label>
                    <input id="ecf-gostknca_password" name="ecf[gostknca][password]" type="password" class="form-control" placeholder="Пароль">
                </div>
                <div class="form-group">
                    <label for="ecf-gostknca_date_finish" class="block">Срок действия</label>
                    <input id="ecf-gostknca_date_finish" name="ecf[gostknca][date_finish]" type="datetime" data-type="date" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div id="ip-company" class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>Владелец ИП</h5>
                </div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="requisites-owner_date_of_birth" class="block">Дата рождения владельца ИП</label>
                        <input id="requisites-owner_date_of_birth" name="requisites[owner_date_of_birth]" type="datetime" data-type="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="requisites-owner_passport" class="block">Удостоверение личности владельца ИП</label>
                        <input data-format="999999999" id="requisites-owner_passport" name="requisites[owner_passport]" type="text" class="form-control" placeholder="Удостоверение личности владельца ИП">
                    </div>
                    <div class="form-group">
                        <label for="requisites-owner_address" class="block">Адрес прописки владельца ИП</label>
                        <textarea id="requisites-owner_address" name="requisites[owner_address]" class="form-control" placeholder="Адрес прописки владельца ИП"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Налоги</h5>
            </div>
            <div class="card-block">
                <div class="form-group ">
                    <label class="span-checkbox">
                        <input name="requisites[cash_register]" value="0" type="checkbox" class="minimal">
                        Наличие кассового аппарата?
                    </label>
                </div>
                <div class="form-group ">
                    <label class="span-checkbox">
                        <input name="requisites[is_excise]" value="0" type="checkbox" class="minimal">
                        Плательщик акциза?
                    </label>
                </div>
                <div class="form-group">
                    <label for="requisites-shop_tax_view_ids" class="block">Местные налоги</label>
                    <select name="requisites[shop_tax_view_ids]" id="requisites-shop_tax_view_ids" class="js-example-basic-multiple" data-type="select2" multiple="multiple" style="width: 100%">
                        <?php echo $siteData->globalDatas['view::_shop/tax/view/list/list']; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Контакты</h5>
            </div>
            <div class="card-block">
                <table class="table table-hover table-db table-tr-line">
                    <thead>
                    <tr>
                        <th style="width: 50%">Контакт</th>
                        <th style="width: 50%">Примечание</th>
                        <th style="min-width: 85px;"></th>
                    </tr>
                    </thead>
                    <tbody id="contacts">
                    <tr>
                        <td>
                            <input name="requisites[contacts][0][contact]" type="text" class="form-control" placeholder="Контакт">
                        </td>
                        <td>
                            <input name="requisites[contacts][0][info]" type="text" class="form-control" placeholder="Примечание">
                        </td>
                        <td>
                            <ul class="list-inline tr-button delete">
                                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> удалить</a></li>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-contact', 'contacts', true);">Добавить контакт</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Учередители</h5>
    </div>
    <div class="card-block">
        <table class="table table-hover table-db table-tr-line">
            <thead>
            <tr>
                <th style="width: 33%">ФИО</th>
                <th style="width: 33%">ИИН</th>
                <th style="width: 33%">Доля</th>
                <th style="min-width: 85px;"></th>
            </tr>
            </thead>
            <tbody id="owners">
            <tr>
                <td>
                    <input name="requisites[owners][0][name]" type="text" class="form-control" placeholder="ФИО учередителя">
                </td>
                <td>
                    <input data-format="999999999999" name="requisites[owners][0][iin]" type="text" class="form-control" placeholder="ИИН учередителя">
                </td>
                <td>
                    <input name="requisites[owners][0][share]" type="text" class="form-control" placeholder="Доля учередителя">
                </td>
                <td>
                    <ul class="list-inline tr-button delete">
                        <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> удалить</a></li>
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-owner', 'owners', true);">Добавить учередителя</button>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>ОКЭД</h5>
    </div>
    <div class="card-block">
        <table class="table table-hover table-db table-tr-line">
            <thead>
            <tr>
                <th style="width: 120px">Источник данных</th>
                <th style="width: 100%;">Вид деятельности</th>
                <th style="width: 120px">Дата начала</th>
                <th style="width: 120px">Дата окончания</th>
                <th style="min-width: 85px;"></th>
            </tr>
            </thead>
            <tbody id="okeds">
            </tbody>
        </table>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-oked', 'okeds', true);">Добавить строчку</button>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Сведение о кассовых аппаратах</h5>
    </div>
    <div class="card-block">
        <table class="table table-hover table-db table-tr-line">
            <thead>
            <tr>
                <th style="width: 50%;">Марка</th>
                <th style="min-width: 145px">Заводской номер</th>
                <th style="min-width: 145px">Номер паспорта</th>
                <th style="min-width: 115px">Год выпуска</th>
                <th style="width: 120px">Постановка на учет</th>
                <th style="width: 50%;">Адрес местоположения</th>
                <th style="min-width: 85px;"></th>
            </tr>
            </thead>
            <tbody id="kkms">
            </tbody>
        </table>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-kkm', 'kkms', true);">Добавить строчку</button>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Примечание</h5>
    </div>
    <div class="card-block">
        <div class="form-group">
            <label for="requisites-text" class="block">Примечание</label>
            <textarea rows="7" id="requisites-text" name="requisites[text]" class="form-control" placeholder="Примечание"></textarea>
        </div>
    </div>
</div>
<div class="text-center" style="width: 100%;">
    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Сохранить</button>
    <a href="/nur-admin/shopbranch/index" class="btn btn-danger">Отменить</a>
</div>
<div id="new-owner" data-index="0">
    <!--
    <tr>
        <td>
            <input name="requisites[owners][_#index#][name]" type="text" class="form-control" placeholder="ФИО учередителя">
        </td>
        <td>
            <input data-format="999999999999" name="requisites[owners][_#index#][iin]" type="text" class="form-control" placeholder="ИИН учередителя">
        </td>
        <td>
            <input name="requisites[owners][_#index#][share]" type="text" class="form-control" placeholder="Доля учередителя">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div id="new-contact" data-index="0">
    <!--
    <tr>
        <td>
            <input name="requisites[contacts][_#index#][contact]" type="text" class="form-control" placeholder="Контакт">
        </td>
        <td>
            <input name="requisites[contacts][_#index#][info]" type="text" class="form-control" placeholder="Примечание">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div id="new-oked" data-index="0">
    <!--
    <tr>
        <td>
            <input name="requisites[okeds][_#index#]][number]" type="text" class="form-control" placeholder="Источник данных">
        </td>
        <td>
            <input name="requisites[okeds][_#index#]][name]" type="text" class="form-control" placeholder="Вид деятельности">
        </td>
        <td>
            <input name="requisites[okeds][_#index#]][date_from]" type="datetime" data-type="date" class="form-control">
        </td>
        <td>
            <input name="requisites[okeds][_#index#]][date_to]" type="datetime" data-type="date" class="form-control">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div id="new-kkm" data-index="0">
    <!--
    <tr>
        <td>
            <input name="requisites[kkms][_#index#][marka]" type="text" class="form-control" placeholder="Марка">
        </td>
        <td>
            <input name="requisites[kkms][_#index#][number]" type="text" class="form-control" placeholder="Заводской номер">
        </td>
        <td>
            <input name="requisites[kkms][_#index#][password_number]" type="text" class="form-control" placeholder="Номер паспорта">
        </td>
        <td>
            <input data-format="9999"  name="requisites[kkms][_#index#][year]" type="text" class="form-control" placeholder="Год выпуска">
        </td>
        <td>
            <input name="requisites[kkms][_#index#][date]" type="datetime" data-type="date" class="form-control">
        </td>
        <td>
            <input name="requisites[kkms][_#index#][address]" type="text" class="form-control" placeholder="Адрес местоположения">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<script>
    $('#requisites-organization_type_id').change(function () {
        if($(this).val() != 739){
            $('#ip-company').css('display', 'none');
        }else{
            $('#ip-company').css('display', 'block');
        }
    });
    $('#requisites-organization_type_id').change();
</script>