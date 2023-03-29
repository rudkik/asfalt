<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="1"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <label class="col-md-2 control-label"></label>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_disable_dumping" value="0" style="display: none">
            <input name="is_disable_dumping" <?php if (Arr::path($data->values, 'is_disable_dumping', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="1"';} ?> type="checkbox" class="minimal">
            Отключить демпинг цен
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        БИН
    </label>
    <div class="col-md-4">
        <input name="bin" type="text" class="form-control" placeholder="БИН" required value="<?php echo htmlspecialchars($data->values['bin'], ENT_QUOTES);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Название
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Минимальная наценка на товар
    </label>
    <div class="col-md-4">
        <input name="min_markup" type="phone" class="form-control" placeholder="Минимальная наценка на товар" value="<?php echo htmlspecialchars($data->values['min_markup'], ENT_QUOTES);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Организация
    </label>
    <div class="col-md-4">
        <input name="name_organization" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['name_organization'], ENT_QUOTES);?>" placeholder="Организация">
    </div>
    <label class="col-md-2 control-label">
        Номер телефона
    </label>
    <div class="col-md-4">
        <input name="phone" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['phone'], ENT_QUOTES);?>" placeholder="Номер телефона">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Банк
    </label>
    <div class="col-md-4">
        <input name="bank_name" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['bank_name'], ENT_QUOTES);?>" placeholder="Банк">
    </div>
    <label class="col-md-2 control-label">
        Номер счета
    </label>
    <div class="col-md-4">
        <input name="bank_number" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['bank_number'], ENT_QUOTES);?>" placeholder="Номер счета">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Должность
    </label>
    <div class="col-md-4">
        <input name="director_position" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['director_position'], ENT_QUOTES);?>" placeholder="Должность">
    </div>
    <label class="col-md-2 control-label">
        ФИО
    </label>
    <div class="col-md-4">
        <input name="director_name" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['director_name'], ENT_QUOTES);?>" placeholder="ФИО">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Адрес
    </label>
    <div class="col-md-5">
        Юридический
        <input name="legal_address" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['legal_address'], ENT_QUOTES);?>" placeholder="Юридический">
    </div>
    <div class="col-md-5">
        Почтовый
        <input name="post_address" type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['post_address'], ENT_QUOTES);?>" placeholder="Почтовый">
    </div>
</div>
<div class="form-group">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>