<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/save" method="post" style="padding-right: 5px;">
<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                <span class="span-checkbox">
                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                    Показать контакт
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
        </div>

        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Вид контакта
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-9">
                <select name="contact_type_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0"></option>
                    <?php echo trim($siteData->globalDatas['view::contacttypes/list']); ?>
                </select>
            </div>
        </div>

        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Контакт
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-9">
                <input name="contact" type="text" class="form-control" placeholder="+7 777 777 77 77">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    Примечание
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
            <div class="col-md-9">
                <textarea name="contact_info" placeholder="Примечание" rows="7" class="form-control"></textarea>
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
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer  text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
</form>