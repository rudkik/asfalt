<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab4" data-toggle="tab">Описание <i class="fa fa-fw fa-info text-blue"></i></a></li>

                <?php if ((Func::isShopMenu('shopnewrubric/seo?type='.$data->values['id'], array(), $siteData))){ ?>
                    <li class=""><a href="#tab71" data-toggle="tab">SEO-настройки рубрик <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ((Func::isShopMenu('shopnew/seo?type='.$data->values['id'], array(), $siteData))){ ?>
                    <li class=""><a href="#tab72" data-toggle="tab">SEO-настройки статей <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ((Func::isShopMenu('shopnewchild/seo?type='.$data->values['id'], array(), $siteData))){ ?>
                    <li class=""><a href="#tab73" data-toggle="tab">SEO-настройки подстатей <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab4">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать вид статей
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>

                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab margin-top-15px">
                        <div class="col-md-3 record-title">
                            <label>
                                Дополнительные <br>параметры
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>

                        </div>
                        <div class="col-md-9">
                            <?php
                            $view = View::factory('cabinet/35/_addition/options');
                            $view->siteData = $siteData;
                            $view->data = $data;
                            echo Helpers_View::viewToStr($view);
                            ?>
                        </div>
                    </div>
                </div>
                <?php if ((Func::isShopMenu('shopnewrubric/seo?type='.$data->values['id'], array(), $siteData))){ ?>
                    <div class="tab-pane" id="tab71">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = 'shop_new_rubric';
                        $view->rootSEOName = '';
                        $view->tableName = Model_Shop_Table_Rubric::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
                <?php if ((Func::isShopMenu('shopnew/seo?type='.$data->values['id'], array(), $siteData))){ ?>
                    <div class="tab-pane" id="tab72">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = 'shop_new';
                        $view->rootSEOName = '';
                        $view->tableName = Model_Shop_New::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
                <?php if ((Func::isShopMenu('shopnewchild/seo?type='.$data->values['id'], array(), $siteData))){ ?>
                    <div class="tab-pane" id="tab73">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = 'shop_new_child';
                        $view->rootSEOName = '';
                        $view->tableName = Model_Shop_NewChild::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
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
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>