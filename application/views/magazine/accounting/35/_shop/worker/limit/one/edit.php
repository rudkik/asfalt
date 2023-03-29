<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Работник
        </label>
    </div>
    <div class="col-md-3">
        <select data-type="select2" id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Лимит
        </label>
    </div>
    <div class="col-md-3">
        <input name="amount" type="text" class="form-control" placeholder="Лимит" value="<?php echo htmlspecialchars(Arr::path($data->values, 'amount', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Месяц
        </label>
    </div>
    <div class="col-md-3">
        <?php $month = Helpers_DateTime::getMonth($data->values['date']); ?>
        <select name="month" class="form-control select2" data-type="select2" style="width: 100%" required>
            <option value="1" data-id="1" <?php if($month == 1){echo 'selected';} ?>>Январь</option>
            <option value="2" data-id="2" <?php if($month == 2){echo 'selected';} ?>>Февраль</option>
            <option value="3" data-id="3" <?php if($month == 3){echo 'selected';} ?>>Март</option>
            <option value="4" data-id="4" <?php if($month == 4){echo 'selected';} ?>>Апрель</option>
            <option value="5" data-id="5" <?php if($month == 5){echo 'selected';} ?>>Май</option>
            <option value="6" data-id="6" <?php if($month == 6){echo 'selected';} ?>>Июнь</option>
            <option value="7" data-id="7" <?php if($month == 7){echo 'selected';} ?>>Июль</option>
            <option value="8" data-id="8" <?php if($month == 8){echo 'selected';} ?>>Август</option>
            <option value="9" data-id="9" <?php if($month == 9){echo 'selected';} ?>>Сентябрь</option>
            <option value="10" data-id="10" <?php if($month == 10){echo 'selected';} ?>>Октябрь</option>
            <option value="11" data-id="11" <?php if($month == 11){echo 'selected';} ?>>Ноябрь</option>
            <option value="12" data-id="12" <?php if($month == 12){echo 'selected';} ?>>Декабрь</option>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Год
        </label>
    </div>
    <div class="col-md-3">
        <input name="year" type="text" class="form-control" placeholder="Год" value="<?php echo htmlspecialchars(Helpers_DateTime::getYear($data->values['date']), ENT_QUOTES);?>" required>
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