<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <label class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <?php if (((Func::isShopMenu('shopaddresscontact/land', $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    Страна
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" style="width: 100%;" name="land_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::land/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopaddresscontact/city', $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    Город
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div id="city_id" class="col-md-3">
                                <select class="form-control select2" style="width: 100%;" name="city_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php
                                    if (key_exists('view::city/list/list', $siteData->globalDatas)){
                                        echo trim($siteData->globalDatas['view::city/list/list']);
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Вид контакта
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="contact_type_id" class="form-control select2" style="width: 100%;">
                                <option value="0" data-id="0"></option>
                                <?php echo trim($siteData->globalDatas['view::contacttype/list/list']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Контакт
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="+7 777 777 77 77" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                    </div>
                    <?php if (Func::isShopMenu('shopaddresscontact/rubric', $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    Рубрика
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_table_rubric_id" class="form-control select2" style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/_table/rubric/list/list']); ?>
                                </select>
                            </div>
                        </div>
                        <div id="options-rubric" class="margin-top-10px">
                            <?php
                            $view = View::factory('cabinet/35/_addition/options/edit');
                            $view->siteData = $siteData;
                            $view->data = $data;
                            $view->className = 'record-tab';
                            $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_table_rubric', array());
                            if(count($view->fields) > 0) {
                                echo Helpers_View::viewToStr($view);
                            }
                            ?>
                        </div>
                    <?php } ?>
                    <?php if ((Func::isShopMenu('shopaddresscontact/text', $siteData))
                    || (Func::isShopMenu('shopaddresscontact/text-html', $siteData))){ ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    Примечание
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9 record-textarea">
                                <textarea name="text" placeholder="Примечание" rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row record-input record-tab margin-t-15">
                        <div class="col-md-3 record-title">
                            <label>
                                Для каких стран показывать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="land_ids[]" class="form-control select2" multiple="multiple" data-placeholder="Выберите страны" style="width: 100%;">
                                <?php
                                $s = '<option data-id="0" value="0">Везде</option>'.trim($siteData->replaceDatas['view::land/list/list']);
                                foreach ($data->values['land_ids'] as $land){
                                    $d = 'data-id="'.$land.'"';
                                    $s = str_replace($d, $d.' selected', $s);
                                }
                                echo $s;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php
        if (Func::isShopMenu('shopaddresscontact/image', $siteData)){
            $view = View::factory('cabinet/35/_addition/files');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->columnSize = 12;
            echo Helpers_View::viewToStr($view);
        }
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
<?php if (Func::isShopMenu('shopaddresscontact/text-html', $siteData)){ ?>
<script>
    CKEDITOR.replace('text');
</script>
<?php } ?>
