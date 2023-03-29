<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" value="1" checked type="checkbox" class="minimal">
                                Непрочитанное
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    ФИО пользователя
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9">
                <input name="name" type="name" class="form-control" placeholder="ФИО пользователя">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    E-mail
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9">
                <input name="email" type="email" class="form-control" placeholder="E-mail">
            </div>
        </div>

        <div class="margin-t-15">
            <?php
            $view = View::factory('cabinet/35/_addition/options/edit');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->className = 'record-list';
            $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_message_catalog_id.options', array());
            echo Helpers_View::viewToStr($view);
            ?>
        </div>        
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Сообщение
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9 record-textarea">
                <textarea name="text" placeholder="Сообщение" rows="11" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="col-md-3">
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
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

<script>
    CKEDITOR.replace('text');
</script>