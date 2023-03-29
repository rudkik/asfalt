<div class="col-md-12">
    <div class="form-horizontal box-partner-goods-edit">
        <div class="box-body">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ФИО</label>
                <div class="col-sm-10">
                    <input name="name" class="form-control" id="name" placeholder="ФИО" type="text">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">E-mail</label>
                <div class="col-sm-10">
                    <input name="email" class="form-control" id="email" placeholder="E-mail" type="text">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Пароль</label>
                <div class="col-sm-10">
                    <input name="password" class="form-control" id="password" placeholder="Пароль" type="password">
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-sm-2 control-label">Телефон</label>
                <div class="col-sm-10">
                    <input name="options[phone]" class="form-control" id="phone" placeholder="Телефон" type="text">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php }else{ ?>
            <input name="type" value="<?php echo $data->values['shop_table_catalog_id'];?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
    </div>
</div>