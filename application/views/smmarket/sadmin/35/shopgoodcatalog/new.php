<div class="col-md-9">
    <div class="form-horizontal box-partner-goods-edit">
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-3">
                    <label>
                        <input name="is_public" value="1" type="checkbox" class="minimal" checked>
                        Опубликовать
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Название</label>
                <div class="col-sm-10">
                    <input name="name" class="form-control" id="name" placeholder="Название товар" type="text">
                </div>
            </div>
            <div class="form-group">
                <label for="shop_table_rubric_id" class="col-sm-2 control-label">Родитель</label>
                <div class="col-sm-10">
                    <select name="root_id" class="form-control select2" id="root_id" style="width: 100%;">
                        <option value="0"></option>
                        <?php echo trim($siteData->globalDatas['view::shopgoodcatalogs/list']); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="info" class="col-sm-2 control-label">Описание</label>
                <div class="col-sm-10">
                    <textarea name="info" class="form-control" id="info" rows="5" placeholder="Описание"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <?php
    $view = View::factory('smmarket/sadmin/35/_addition/files');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->columnSize = 12;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="col-md-12">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <input name="type" value="3722">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
    </div>
</div>


