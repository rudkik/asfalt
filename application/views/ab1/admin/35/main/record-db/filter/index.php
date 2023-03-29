<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <?php foreach ($data->additionDatas['fields'] as $name => $field) { ?>
                    <?php if($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER){ ?>
                        <?php if(key_exists('table', $field) && $field['table'] == DB_Ab1_Shop_Client::NAME){?>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt($name);?>"
                                            id="<?php echo $name; ?>" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                        <?php }elseif(key_exists('table', $field) && $field['table']::IS_CATALOG){?>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                    <select id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="form-control select2" required style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt($name); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                                        <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::' .DB_Basic::getViewPath($field['table']). 'list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                    <input id="<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Request_RequestParams::getParamInt($name);?>" type="text">
                                </div>
                            </div>
                        <?php }?>
                    <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_FLOAT){ ?>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                <input id="<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Request_RequestParams::getParamFloat($name);?>" type="text">
                            </div>
                        </div>
                    <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_BOOLEAN){ ?>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                <select id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="form-control select2" required style="width: 100%;">
                                    <?php $tmp = Request_RequestParams::getParamBoolean($name); ?>
                                    <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>>Выберите значение</option>
                                    <option value="1" data-id="1" <?php if($tmp === true){echo 'selected';} ?>>Да</option>
                                    <option value="0" data-id="0" <?php if($tmp === false){echo 'selected';} ?>>Нет</option>
                                </select>
                            </div>
                        </div>
                    <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_DATE_TIME){ ?>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                <input id="<?php echo $name; ?>" class="form-control" date-type="datetime" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Request_RequestParams::getParamDateTime($name));?>" type="datetime">
                            </div>
                        </div>
                    <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_DATE){ ?>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                <input id="<?php echo $name; ?>" class="form-control" date-type="date" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDateTime($name));?>" type="datetime">
                            </div>
                        </div>
                    <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_TIME){ ?>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                <input id="<?php echo $name; ?>" class="form-control" date-type="time" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Helpers_DateTime::getTimeFormatRus(Request_RequestParams::getParamDateTime($name));?>" type="datetime">
                            </div>
                        </div>
                    <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_STRING){ ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                                <input id="<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Request_RequestParams::getParamStr($name);?>" type="text">
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="col-md-7" style="display: none">
                    <div hidden>
                        <?php if($siteData->branchID > 0){ ?>
                            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                        <?php } ?>

                        <?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){?>
                            <input id="input-status" name="is_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){?>
                            <input id="input-status" name="is_not_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_delete', '') == 1){?>
                            <input id="input-status" name="is_delete" value="1">
                        <?php }else{?>
                            <input id="input-status" name="" value="1">
                        <?php }?>
                    </div>
                </div>
                <div class="col-md-2 pull-right">
                    <div class="form-group pull-right">
                        <label for="input-limit-page">Кол-во записей</label>
                        <div class="input-group" style="width: 145px;">
                            <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                <?php $tmp = Request_RequestParams::getParamInt('limit_page'); ?>
                                <option value="25" <?php if(($tmp === NULL) || ($tmp == 25)){echo 'selected';} ?>>25</option>
                                <option value="50" <?php if($tmp == 50){echo 'selected';} ?>>50</option>
                                <option value="100" <?php if($tmp == 100){echo 'selected';} ?>>100</option>
                                <option value="200" <?php if($tmp == 200){echo 'selected';} ?>>200</option>
                                <option value="500" <?php if($tmp == 500){echo 'selected';} ?>>500</option>
                                <option value="1000" <?php if($tmp == 1000){echo 'selected';} ?>>1000</option>
                                <option value="5000" <?php if($tmp == 5000){echo 'selected';} ?>>5000</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="submit" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    .select2-container {
        margin-top: -4px;
    }
</style>