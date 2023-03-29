<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                <span class="span-checkbox">
                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                    Показать рубрику
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-9">
                <input name="name" type="text" class="form-control" placeholder="Название">
            </div>
        </div>

        <?php if ((((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnewrubric/index-root?type='.Request_RequestParams::getParamInt('type'), array(), $siteData))))
        || (Func::isShopMenu('shopnewrubric/index-all-root', array(), $siteData))){ ?>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <label>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Родитель
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="col-md-9">
                    <select name="root_id" class="form-control select2" style="width: 100%;">
                        <option value="0" data-id="0">Рубрика верхнего уровня</option>
                        <?php echo trim($siteData->globalDatas['view::shopnewrubrics/list']); ?>
                    </select>
                </div>
            </div>
        <?php } ?>

        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Описание
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9 record-textarea">
                <textarea name="info" placeholder="Описание..." rows="11" class="form-control"></textarea>
            </div>
        </div>

        <?php if ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnewrubric/index-params?type='.Request_RequestParams::getParamInt('type'), array(), $siteData))){ ?>
            <div class="row record-input record-list margin-top-15px">
                <div class="col-md-3 record-title">
                    <span>
                        Дополнительные <br>параметры статей
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </span>

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
        <?php } ?>
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
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    CKEDITOR.replace('info');
</script>


