<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ФИО
        </label>
    </div>
    <div class="col-md-3">
        <input name="name" type="text" class="form-control" placeholder="ФИО" required value="<?php echo $data->values['name'] ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            ИИН
        </label>
    </div>
    <div class="col-md-3">
        <input name="iin" type="phone" class="form-control" placeholder="ИИН" value="<?php echo $data->values['iin'] ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Номер удостоверения
        </label>
    </div>
    <div class="col-md-3">
        <input name="passport_number" type="phone" class="form-control" placeholder="Номер удостоверения" value="<?php echo $data->values['passport_number'] ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Название компании
        </label>
    </div>
    <div class="col-md-3">
        <input name="company_name" type="text" class="form-control" placeholder="Название компании" value="<?php echo $data->values['company_name'] ?>">
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