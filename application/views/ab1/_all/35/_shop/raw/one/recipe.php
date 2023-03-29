<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Сырье
        </label>
    </div>
    <div class="col-md-9">
        <input type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>" readonly>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Название рецента
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="name_recipe" class="form-control" placeholder="Название рецента" <?php if($isShow){ ?>readonly<?php } ?>><?php echo htmlspecialchars(Arr::path($data->values, 'name_recipe', ''), ENT_QUOTES);?></textarea>
    </div>
</div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Реценты
            </label>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 10px">
                    <?php $formulaTypeIDs = Arr::path($siteData->operation->getAccessArray(), 'formula_type_ids', NULL); ?>
                    <a href="<?php echo Func::getFullURL($siteData, '/shopformularaw/new', array('shop_raw_id' => 'id'));?>" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-plus"></i> Добавить рецепт</a>
                </div>
                <div class="col-md-12">
                    <?php echo $siteData->globalDatas['view::_shop/formula/raw/list/recipe'];?>
                </div>
            </div>
        </div>
    </div>

<?php if(!$isShow){ ?>
<div class="row">
    <div hidden>
        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="submitSave('shopformularaw');">Сохранить</button>
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shopformularaw');">Применить</button>
    </div>
</div>
<script>
    function submitSave(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }
</script>
<?php } ?>