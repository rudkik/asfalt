<h1>Новая торговая точка</h1>
<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom nav-tabs-success">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li class="active"><a href="#site" data-toggle="tab" aria-expanded="true">Данные на сайт</a></li>
                <li><a href="#manager" data-toggle="tab" aria-expanded="false">Данные менеджеру</a></li>
                <li><a href="#legal" data-toggle="tab" aria-expanded="false">Юридические данные</a></li>
            </ul>
            <div class="tab-content no-padding box-partner-edit">
                <div class="tab-pane" id="manager">
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="manager_company_name" class="col-sm-2 control-label">Менеджер по развитию</label>
                                <div class="col-sm-10">
                                    <input name="options[manager_company_name]" class="form-control" id="manager_company_name" placeholder="Менеджер по развитию" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manager_name" class="col-sm-2 control-label">Менеджер торговой точки</label>
                                <div class="col-sm-10">
                                    <input name="options[manager_name]" class="form-control" id="manager_name" placeholder="Менеджер" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manager_phone" class="col-sm-2 control-label">Телефоны</label>
                                <div class="col-sm-10">
                                    <input name="options[manager_phone]" class="form-control" id="manager_phone" placeholder="+7 777 777 77 77" type="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manager_address" class="col-sm-2 control-label">Адрес</label>
                                <div class="col-sm-10">
                                    <textarea name="options[manager_address]" class="form-control" id="manager_address" rows="3" placeholder="Адрес"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manager_number_plane_table" class="col-sm-2 control-label">№ планшета</label>
                                <div class="col-sm-10">
                                    <input name="options[manager_number_plane_table]" class="form-control" id="manager_number_plane_table" placeholder="№ планшета" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manager_date_plane_table" class="col-sm-2 control-label">Дата выдача планшета</label>
                                <div class="col-sm-10">
                                    <input name="options[manager_date_plane_table]" class="form-control" id="manager_date_plane_table" placeholder="Дата выдачи планшета" type="datetime">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manager_phone_plane_table" class="col-sm-2 control-label">Номер телефона на планшете</label>
                                <div class="col-sm-10">
                                    <input name="options[manager_phone_plane_table]" class="form-control" id="manager_phone_plane_table" placeholder="+7 777 777 77 77" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manager_comment" class="col-sm-2 control-label">Примечание</label>
                                <div class="col-sm-10">
                                    <textarea name="options[manager_comment]" class="form-control" id="manager_comment" rows="5" placeholder="Примечание"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active"" id="site">
                <div class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <label>
                                    <input type="checkbox" class="minimal" name="is_public" value="1" checked>
                                    Опубликовать
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label>
                                    <input type="checkbox" class="minimal" name="is_active" value="1" checked>
                                    Активировать
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Название</label>
                            <div class="col-sm-10">
                                <input name="name" class="form-control" id="name" placeholder="Название" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city_id" class="col-sm-2 control-label">Класс торговой точки</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="shop_branch_catalog_id" name="shop_branch_catalog_id" style="width: 100%;">
                                    <option value="0" data-id="0">Выберите класс</option>
                                    <?php echo trim($siteData->globalDatas['view::shopbranchcatalogs/list']); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city_id" class="col-sm-2 control-label">Город</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="city_id" style="width: 100%;">
                                    <option value="0">Город не выбран</option>
                                    <?php echo trim($siteData->globalDatas['view::cities/list']); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site_address" class="col-sm-2 control-label">Адрес</label>
                            <div class="col-sm-10">
                                <textarea name="options[site_address]" class="form-control" id="site_address" rows="2" placeholder="Адрес откуда можно забрать товар"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site_map" class="col-sm-2 control-label">Ссылка на карту</label>
                            <div class="col-sm-10">
                                <span><a href="https://yandex.ru/map-constructor/" target="_blank">https://yandex.ru/map-constructor/</a></span>
                                <textarea name="options[site_map]" class="form-control" id="site_map" rows="2" placeholder="Ссылка на карту"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site_address" class="col-sm-2 control-label">Телефоны</label>
                            <div class="col-sm-10">
                                <div class="row" id="phones-list" data-index="0">
                                    <?php
                                    $phones = Arr::path($data->values, 'options.site_phones', array());
                                    if((is_array($phones)) && (count($phones))) {
                                        $i = 0;
                                        foreach ($phones as $phone) {
                                            ?>
                                            <div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input name="options[site_phones][<?php echo $i; ?>][phone]" class="form-control"
                                                                   id="site_phone" placeholder="+7 777 777 77 77" type="phone"
                                                                   value="<?php echo Arr::path($phone, 'phone', ''); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="site_phone" class="col-sm-4 control-label">Примечание</label>
                                                        <div class="col-sm-8">
                                                            <input name="options[site_phones][<?php echo $i; ?>][info]" class="form-control"
                                                                   id="site_phone" placeholder="Примечание" type="text"
                                                                   value="<?php echo Arr::path($phone, 'info', ''); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-top: 7px;">
                                                    <a href="" class="link-red text-sm" data-action="phone-delete"><i class="fa fa-remove"></i></a>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                    }else{?>
                                        <div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <input name="options[site_phones][0][phone]" class="form-control"
                                                               id="site_phone" placeholder="+7 777 777 77 77" type="phone">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label for="site_phone" class="col-sm-4 control-label">Примечание</label>
                                                    <div class="col-sm-8">
                                                        <input name="options[site_phones][0][info]" class="form-control"
                                                               id="site_phone" placeholder="Примечание" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="padding-top: 7px;">
                                                <a href="" class="link-red text-sm" data-action="phone-delete"><i class="fa fa-remove"></i></a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row" id="phone-add">
                                    <!--
                                    <div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input name="options[site_phones][#index#][phone]" class="form-control"
                                                           id="site_phone" placeholder="+7 777 777 77 77" type="phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="site_phone" class="col-sm-4 control-label">Примечание</label>
                                                <div class="col-sm-8">
                                                    <input name="options[site_phones][#index#][info]" class="form-control"
                                                           id="site_phone" placeholder="Примечание" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 7px;">
                                            <a href="" class="link-red text-sm" data-action="phone-delete"><i class="fa fa-remove"></i></a>
                                        </div>
                                    </div>
                                    -->
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-success pull-right" onclick="addPhone('phones-list', 'phone-add')">Добавить телефон</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="params_email" class="col-sm-2 control-label">E-mail для системных сообщений</label>
                            <div class="col-sm-10">
                                <textarea name="params[<?php echo Model_Shop::PARAM_NAME_SEND_EMAIL_INFO; ?>]" class="form-control" id="params_email" rows="2" placeholder="E-mail для системных сообщений"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site_email" class="col-sm-2 control-label">E-mail для поставщиков</label>
                            <div class="col-sm-10">
                                <textarea name="options[site_email]" class="form-control" id="site_email" rows="2" placeholder="E-mail поставщиков"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site_comment" class="col-sm-2 control-label">Прочее описание</label>
                            <div class="col-sm-10">
                                <textarea name="options[site_comment]" class="form-control" id="site_comment" rows="5" placeholder="Прочее описание"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="legal">
                <div class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="legal_name" class="col-sm-2 control-label">Юридическое название</label>
                            <div class="col-sm-10">
                                <input name="options[legal_name]" class="form-control" id="legal_name" placeholder="Юридическое название" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_address" class="col-sm-2 control-label">Юридический адрес</label>
                            <div class="col-sm-10">
                                <textarea name="options[legal_address]" class="form-control" id="legal_address" rows="2" placeholder="Юридический адрес"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_bin" class="col-sm-2 control-label">БИН/ИИН</label>
                            <div class="col-sm-10">
                                <input name="options[legal_bin]" class="form-control" id="legal_bin" placeholder="БИН/ИИН" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_order" class="col-sm-2 control-label">Номер счета</label>
                            <div class="col-sm-10">
                                <textarea name="options[legal_order]" class="form-control" id="legal_order" rows="2" placeholder="Номер счета"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_bank" class="col-sm-2 control-label">Банк</label>
                            <div class="col-sm-10">
                                <input name="options[legal_bank]" class="form-control" id="legal_bank" placeholder="Банк" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_bik" class="col-sm-2 control-label">БИК</label>
                            <div class="col-sm-10">
                                <input name="options[legal_bik]" class="form-control" id="legal_bik" placeholder="БИК" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_director" class="col-sm-2 control-label">Директор</label>
                            <div class="col-sm-10">
                                <input name="options[legal_director]" class="form-control" id="legal_director" placeholder="Директор" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_position_director" class="col-sm-2 control-label">Должность директора</label>
                            <div class="col-sm-10">
                                <input name="options[legal_position_director]" class="form-control" id="legal_position_director" placeholder="Должность директора" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_booker" class="col-sm-2 control-label">Бухгалтер</label>
                            <div class="col-sm-10">
                                <input name="options[legal_booker]" class="form-control" id="legal_booker" placeholder="Бухгалтер" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_booker_director" class="col-sm-2 control-label">Должность бухгалтера</label>
                            <div class="col-sm-10">
                                <input name="options[legal_booker_director]" class="form-control" id="legal_booker_director" placeholder="Должность бухгалтера" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="legal_comment" class="col-sm-2 control-label">Примечание</label>
                            <div class="col-sm-10">
                                <textarea name="options[legal_comment]" class="form-control" id="legal_comment" rows="5" placeholder="Примечание"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div hidden>
                <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
                <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
            </div>
            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
        </div>

    </div>

    <div class="col-md-3">
        <?php
        $view = View::factory('smmarket/sadmin/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>