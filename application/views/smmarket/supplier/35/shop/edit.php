<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <li><a href="#tab2" data-toggle="tab">Режим работы</a></li>
                <li><a href="#tab3" data-toggle="tab">Реквизиты</a></li>
                <li><a href="#tab4" data-toggle="tab">Дополнительные данные</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-4" style="max-width: 200px;">
                            <span class="span-checkbox">
                                <input name="is_block" <?php if ($data->values['is_block'] == 1) { echo ' checked'; } ?> type="checkbox" class="minimal">
                                Заблокировать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                            <a hidden style="margin-left: 20px; text-decoration: underline;" href="<?php echo Func::getBasicURLShop($siteData).'?is_ignore_block=1'; ?>" target="_blank">Просмотр заблокированного сайта</a>
                        </div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать компанию
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                    </div>

                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" rows="5" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                    </div>

                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Поддомен (*.*.*)
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input unique-current-id="<?php echo $data->id;?>" unique-error="Поддомен с таким именем уже существует" unique="1" href="<?php echo $siteData->urlBasic; ?>/cabinet/shop/isunique" name="sub_domain" type="text" class="form-control" id="sub_name" placeholder="Поддомен" value="<?php echo htmlspecialchars($data->values['sub_domain']); ?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                Домен
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input unique-current-id="<?php echo $data->id;?>" unique-error="Домен с таким именем уже существует"  unique="1" href="<?php echo $siteData->urlBasic; ?>/cabinet/shop/isunique" name="domain" type="text" class="form-control" rows="5" placeholder="Название" value="<?php echo htmlspecialchars($data->values['domain']);?>">
                        </div>
                    </div>

                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Описание
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9 record-textarea">
                            <textarea name="info" placeholder="Описание..." rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">

                </div>
                <div class="tab-pane" id="tab3">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Юридическое название
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="requisites[company_name]" type="text" class="form-control" rows="9" placeholder="Юридическое название" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.company_name', ''));?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                БИН
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="requisites[bin]" type="text" class="form-control" rows="9" placeholder="БИН" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.bin', ''));?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                Юридический адрес
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="requisites[address]" type="text" class="form-control" rows="9" placeholder="Юридический адрес" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.address', ''));?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                Банк
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="requisites[bank]" type="text" class="form-control" rows="9" placeholder="Банк" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.bank', ''));?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                БИК
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="requisites[bik]" type="text" class="form-control" rows="9" placeholder="БИК" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.bik', ''));?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                Номер счета (IBAN)
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="requisites[account_number]" type="text" class="form-control" rows="9" placeholder="Номер счета (IBAN)" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.account_number', ''));?>">
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                ФИО директора
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <input name="requisites[director]" type="text" class="form-control" rows="9" placeholder="ФИО директора" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.director', ''));?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <span>
                                Должность директора
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <input name="requisites[director_post]" type="text" class="form-control" rows="9" placeholder="Должность директора" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.director_post', ''));?>">
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title">
                            <span>
                                ФИО бухгалтера
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <input name="requisites[accountant]" type="text" class="form-control" rows="9" placeholder="ФИО бухгалтера" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.accountant', ''));?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <span>
                                Должность бухгалтера
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <input name="requisites[accountant_post]" type="text" class="form-control" rows="9" placeholder="Должность бухгалтера" value="<?php echo htmlspecialchars(Arr::path($data->values, 'requisites.accountant_post', ''));?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $view = View::factory('cabinet/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="is_edit" value="<?php echo Request_RequestParams::getParamBoolean('is_edit');?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>

    <div class="modal-footer  text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    CKEDITOR.replace('info');
</script>

