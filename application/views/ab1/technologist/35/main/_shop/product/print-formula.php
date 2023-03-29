<?php
$time1 = date('d.m.Y');
?>
<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/technologist/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <div class="col-md-12">
                <div class="row">
                    <h3>Рецепты продуктов</h3>
                    <?php $formulaTypeIDs = Arr::path($siteData->operation->getAccessArray(), 'formula_type_ids', NULL); ?>
                    <div class="modal-footer text-center">
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_asphalt', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT));?>">Сохранить в формате асфальт</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_asphalt_bunker', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER));?>">Сохранить в формате асфальт с учетом бункерного рассева</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_zhbi', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI));?>">Сохранить в формате ЖБИ</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_emulsion', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION));?>">Сохранить в формате эмульсии</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_concrete', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE));?>">Сохранить в формате бетона</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_SYSTEM, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_system', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_SYSTEM));?>">Сохранить системные рецепты</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <h3>Рецепты материалов</h3>
                    <div class="modal-footer text-center">
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_bitumen_fuel_oil', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL));?>">Сохранить в формате битум с топливным компонентом</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_bitumen', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN));?>">Сохранить в формате битум</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_concrete', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE));?>">Сохранить в бетон</a>
                        <?php } ?>
                        <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM, $formulaTypeIDs) !== false){ ?>
                            <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_system', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM));?>">Сохранить в формате ЖБИ</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>