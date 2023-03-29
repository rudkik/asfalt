<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab4" data-toggle="tab">Описание <i class="fa fa-fw fa-info text-blue"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab4">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>

                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name']);?>">
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
                            <textarea name="text" placeholder="Описание..." rows="3" class="form-control"><?php echo $data->values['text'];?></textarea>
                        </div>
                    </div>
                    <div class="row record-input record-tab margin-t-15">
                        <div class="col-md-3 record-title">
                            <label>
                                Настройки загрузки
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>

                        </div>
                        <div class="col-md-9">
                            <?php
                            $view = View::factory('cabinet/35/_addition/options-load-file');
                            $view->siteData = $siteData;
                            $view->data = $data;
                            echo Helpers_View::viewToStr($view);
                            ?>
                        </div>
                    </div>
                    <div class="row record-input record-tab margin-t-15">
                        <div class="col-md-3 record-title">
                            <span>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Первая строка
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <div class="col-md-9">
                            <input name="first_row" type="text" class="form-control" placeholder="Первая строка" value="<?php echo $data->values['first_row'];?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Excel-файл
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="file-upload" data-text="Выберите Excel-файл">
                                <input type="file" name="file">
                            </div>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_add_data" value="0" type="checkbox" class="minimal">
                                Догрузить данные
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>