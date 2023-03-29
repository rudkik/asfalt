<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/recipe/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <?php
            $view = View::factory('ab1/recipe/35/main/_shop/formula/material/filter');
            $view->siteData = $siteData;
            $view->data = $data;
            echo Helpers_View::viewToStr($view);
            ?>
            <?php $formulaTypeIDs = Arr::path($siteData->operation->getAccessArray(), 'formula_type_ids', NULL); ?>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1, 'is_group' => '1'));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/index', array(), array('is_public_ignore' => 1, 'is_group' => '1'));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <div class="btn-group">
                            <button type="button" class="btn bg-orange btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-fw fa-plus"></i> Добавить рецепт
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL));?>"><i class="fa fa-fw fa-plus"></i> Добавить битум с топливным компонентом</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN));?>"><i class="fa fa-fw fa-plus"></i> Добавить битум</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE));?>"><i class="fa fa-fw fa-plus"></i> Добавить бетон</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM));?>"><i class="fa fa-fw fa-plus"></i> Добавить системные рецепты</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <li class="pull-left header">
                        <div class="btn-group">
                            <button type="button" class="btn bg-purple btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-fw fa-plus"></i> Сохранить в Excel
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_bitumen_fuel_oil', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате битум с топливным компонентом</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_bitumen', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате битум</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_concrete', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в бетон</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulamaterial_system', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_SYSTEM));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате ЖБИ</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/formula/material/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
