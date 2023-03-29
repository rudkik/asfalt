<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_admin" <?php if (Arr::path($data->values, 'is_admin', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Администратор
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ФИО
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="ФИО" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Логин
        </label>
    </div>
    <div class="col-md-9">
        <input name="email" type="text" class="form-control" placeholder="Логин" required value="<?php echo htmlspecialchars($data->values['email'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Пароль
        </label>
    </div>
    <div class="col-md-9">
        <input name="password" type="password" class="form-control" placeholder="Пароль">
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>