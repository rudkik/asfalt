<div class="row">
    <div class="col-md-12">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                <span class="span-checkbox">
                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                    Показать
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-9">
                <input name="name" type="text" class="form-control" placeholder="Название">
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
                <textarea name="text" placeholder="Описание..." rows="3" class="form-control"></textarea>
            </div>
        </div>
        <div class="row record-input record-list margin-t-15">
            <div class="col-md-3 record-title">
                <span>
                    Настройки загрузки
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
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
                <input name="first_row" type="text" class="form-control" placeholder="Первая строка">
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
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type'); ?>">
        <input name="table_id" value="<?php echo Request_RequestParams::getParamInt('table_id'); ?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>