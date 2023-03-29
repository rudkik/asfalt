<div class="col-md-9">
    <div class="form-horizontal box-partner-discount-edit">
        <div class="box-body">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <label>
                        <input name="is_public" type="checkbox" class="minimal" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> >
                        Запустить скидку
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Товар</label>
                <div class="col-sm-10">
                    <select name="shop_good_id" class="form-control select2" style="width: 100%;">
                        <option value="0" data-id="0">Выберите товар</option>
                        <?php echo trim($siteData->globalDatas['view::shopgoods/list']); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Дата запуска</label>
                <div class="col-sm-10">
                    <input name="from_at" class="form-control" id="inputEmail3" type="datetime" value="<?php echo $data->values['from_at']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Дата окончания</label>
                <div class="col-sm-10">
                    <input name="to_at" class="form-control" id="inputEmail3" type="datetime" value="<?php echo $data->values['to_at']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Скидка</label>
                <div class="col-sm-10">
                    <input name="discount" class="form-control" id="inputEmail3" placeholder="Скидка" type="text" value="<?php echo Func::getNumberStr($data->values['discount'], FALSE); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Описание</label>
                <div class="col-sm-10">
                    <textarea name="bill_comment" class="form-control" id="inputEmail3" rows="5" placeholder="Описание"><?php echo $data->values['bill_comment']; ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div hidden>
            <?php if($siteData->branchID > 0){ ?>
                <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
            <?php } ?>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php }else{ ?>
                <input name="type" value="<?php echo $data->values['shop_table_catalog_id'];?>">
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/datetime/jquery.datetimepicker.css"/>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/datetime/jquery.datetimepicker.js"></script>
<script>
    $(document).ready(function () {
        $('input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y H:i',
        });
    });
</script>