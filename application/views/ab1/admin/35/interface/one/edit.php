
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" readonly>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Код интерфейса
        </label>
    </div>
    <div class="col-md-3">
        <input name="code" type="text" class="form-control" placeholder="Код интерфейса" value="<?php echo htmlspecialchars($data->values['code'], ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Номер последнего отчета
        </label>
    </div>
    <div class="col-md-3">
        <input name="report_number" type="phone" class="form-control" placeholder="Номер последнего отчета" value="<?php echo htmlspecialchars($data->values['report_number'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

