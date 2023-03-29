<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Активировать телефон
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    ФИО
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9">
                <input name="name" type="text" class="form-control" placeholder="ФИО" value="<?php echo htmlspecialchars($data->values['name']);?>">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Телефон
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9">
                <input name="phone" type="phone" class="form-control" placeholder="Телефон" value="<?php echo htmlspecialchars($data->values['phone']);?>">
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
                <input name="email" type="email" class="form-control" placeholder="E-mail" value="<?php echo htmlspecialchars($data->values['email']);?>">
            </div>
        </div>

        <div class="margin-t-15">
            <?php
            $view = View::factory('cabinet/35/_addition/options/edit');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->className = 'record-list';
            $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_phone_catalog_id.options', array());
            echo Helpers_View::viewToStr($view);
            ?>
        </div>
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title">
                <label>
                    Примечание
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9 record-textarea">
                <textarea name="text" placeholder="Примечание" rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
            </div>
        </div>
    </div>

    <div class="col-md-3">
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
        <?php }else{ ?>
            <input name="type" value="<?php echo $data->values['shop_client_phone_catalog_id'];?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>