<?php $siteData->titleTop = $data->additionDatas['name'] . ' (редактирование)'; ?>
<form action="<?php echo Func::getFullURL($siteData, '/recorddb/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <?php
        foreach ($data->additionDatas['fields'] as $name => $field) {
            if($name == 'update_user_id'){
                continue;
            }
            ?>
            <?php if($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER){ ?>
                <?php if(key_exists('table', $field) && $field['table'] == DB_Ab1_Shop_Client::NAME){?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                            <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo htmlspecialchars($data->values[$name], ENT_QUOTES);?>"
                                    id="<?php echo $name; ?>" name="shop_client_id" class="form-control select2" style="width: 100%">
                            </select>
                        </div>
                    </div>
                <?php }elseif(key_exists('table', $field) && $field['table']::IS_CATALOG){?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                            <select id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="form-control select2" style="width: 100%;">
                                <?php $tmp = $data->values[$name]; ?>
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
                            <input id="<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo htmlspecialchars($data->values[$name], ENT_QUOTES);?>" type="text">
                        </div>
                    </div>
                <?php }?>
            <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_FLOAT){ ?>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                        <input id="<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo htmlspecialchars($data->values[$name], ENT_QUOTES);?>" type="text">
                    </div>
                </div>
            <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_BOOLEAN){ ?>
                <div class="col-md-1-5">
                    <div class="form-group" style="padding: 29px 0px 10px">
                            <input <?php if ($data->values[$name] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal"> <?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>
                    </div>
                </div>
            <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_DATE_TIME){ ?>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                        <input id="<?php echo $name; ?>" class="form-control" date-type="datetime" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(htmlspecialchars($data->values[$name], ENT_QUOTES));?>" type="datetime">
                    </div>
                </div>
            <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_DATE){ ?>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                        <input id="<?php echo $name; ?>" class="form-control" date-type="date" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Helpers_DateTime::getDateFormatRus(htmlspecialchars($data->values[$name], ENT_QUOTES));?>" type="datetime">
                    </div>
                </div>
            <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_TIME){ ?>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                        <input id="<?php echo $name; ?>" class="form-control" date-type="time" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo Helpers_DateTime::getTimeFormatRus(htmlspecialchars($data->values[$name], ENT_QUOTES));?>" type="datetime">
                    </div>
                </div>
            <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_STRING){ ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="<?php echo $name; ?>"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></label>
                        <input id="<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?>" value="<?php echo htmlspecialchars($data->values[$name], ENT_QUOTES);?>" type="text">
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="row">
        <div hidden>
            <?php if($siteData->action != 'clone') { ?>
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
            <?php } ?>
            <input id="is_close" name="is_close" value="1" style="display: none">
            <input id="db" name="db" value="<?php echo Request_RequestParams::getParamStr('db'); ?>" style="display: none">
        </div>
        <div class="modal-footer text-center">
            <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
            <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
        </div>
    </div>
</form>