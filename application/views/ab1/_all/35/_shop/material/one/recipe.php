<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Материал
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
                    <?php $formulaTypeIDs = $data->values['formula_type_ids']; ?>
                    <div class="btn-group">
                        <a data-action="car-new" href="#" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-plus"></i> Добавить рецепт</a>
                        <button type="button" class="btn bg-orange btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL, $formulaTypeIDs) !== false){ ?>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array('shop_material_id' => 'id'), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL));?>"><i class="fa fa-fw fa-plus"></i> Добавить битум с топливным компонентом</a></li>
                            <?php } ?>
                            <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN, $formulaTypeIDs) !== false){ ?>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array('shop_material_id' => 'id'), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN));?>"><i class="fa fa-fw fa-plus"></i> Добавить битум</a></li>
                            <?php } ?>
                            <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE, $formulaTypeIDs) !== false){ ?>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array('shop_material_id' => 'id'), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE));?>"><i class="fa fa-fw fa-plus"></i> Добавить бетон</a></li>
                            <?php } ?>
                            <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM, $formulaTypeIDs) !== false){ ?>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array('shop_material_id' => 'id'), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM));?>"><i class="fa fa-fw fa-plus"></i> Добавить системные рецепты</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <?php echo $siteData->globalDatas['view::_shop/formula/material/list/recipe'];?>
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
        <button type="button" class="btn btn-primary" onclick="submitSave('shopformulamaterial');">Сохранить</button>
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shopformulamaterial');">Применить</button>
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