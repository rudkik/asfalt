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
            $view = View::factory('ab1/recipe/35/main/_shop/formula/product/filter');
            $view->siteData = $siteData;
            $view->data = $data;
            echo Helpers_View::viewToStr($view);
            ?>
            <?php $formulaTypeIDs = Arr::path($siteData->operation->getAccessArray(), 'formula_type_ids', NULL); ?>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1, 'is_group' => '1'));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/index', array(), array('is_public_ignore' => 1, 'is_group' => '1'));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <div class="btn-group">
                            <button type="button" class="btn bg-orange btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-fw fa-plus"></i> Добавить рецепт
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT));?>"><i class="fa fa-fw fa-plus"></i> Добавить асфальт</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER));?>"><i class="fa fa-fw fa-plus"></i> Добавить асфальт с учетом бункерного рассева</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI, $formulaTypeIDs) !== false){ ?>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI));?>"><i class="fa fa-fw fa-plus"></i> Добавить ЖБИ</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION, $formulaTypeIDs) !== false){ ?>
                                <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION));?>"><i class="fa fa-fw fa-plus"></i> Добавить эмульсию</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE));?>"><i class="fa fa-fw fa-plus"></i> Добавить бетон</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_SYSTEM, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/new', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_SYSTEM));?>"><i class="fa fa-fw fa-plus"></i> Добавить системные рецепты</a></li>
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
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_asphalt', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате асфальт</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_asphalt_bunker', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате асфальт с учетом бункерного рассева</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_zhbi', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате ЖБИ</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_emulsion', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате эмульсии</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_concrete', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE));?>"><i class="fa fa-fw fa-plus"></i> Сохранить в формате бетона</a></li>
                                <?php } ?>
                                <?php if($formulaTypeIDs == null || array_search(Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_SYSTEM, $formulaTypeIDs) !== false){ ?>
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopreport/formulaproduct_system', array(), array('formula_type_id' => Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_SYSTEM));?>"><i class="fa fa-fw fa-plus"></i> Сохранить системные рецепты</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/formula/product/list/index']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
