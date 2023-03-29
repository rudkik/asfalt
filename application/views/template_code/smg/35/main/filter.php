<?php
$openPHP = '<?php';
$closePHP = '?>';

$count = count($fieldsDB);
$a = 0 ;
if($count == 1 || $count == 4){
    $a = 6;
}elseif($count == 2 || $count == 5){
    $a = 2;
}elseif($count == 3 || $count == 6){
    $a = 10;
}

?>
<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <?php foreach ($fieldsDB as $key => $field) { if (!empty($field['title'])) { ?>

                    <?php if (!empty($field['table'])) { if ($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER){ ?>
                <!-- Вывод списка выбора  -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="<?php echo $key; ?>">
                            <?php echo $field['title']; ?>

                        </label>
                        <select id="<?php echo $key; ?>" name="<?php echo $key; ?>" class="form-control select2" required style="width: 100%;">
                            <?php echo $openPHP; ?> $tmp = Request_RequestParams::getParamInt('<?php echo $key; ?>'); <?php echo $closePHP; ?>
                            <option value="-1" data-id="-1" <?php echo $openPHP; ?> if($tmp === NULL || $tmp < 0){echo 'selected';} <?php echo $closePHP; ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php echo $openPHP; ?> if($tmp == 0 && $tmp !== NULL){echo 'selected';} <?php echo $closePHP; ?>>Без значения</option>
                            <?php echo $openPHP; ?>
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::<?php echo Api_MVC::pathView($key); ?>/list/list']));
                            <?php echo $closePHP; ?>

                        </select>
                    </div>
                </div>
                <?php } } elseif ($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER) {?>
                <!-- Вывод числовых+текстовых значений  -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="<?php echo $key; ?>">
                            <?php echo $field['title']; ?>

                        </label>
                        <input id="<?php echo $key; ?>" class="form-control" name="<?php echo $key; ?>" value="<?php echo $openPHP; ?> echo Arr::path($siteData->urlParams, '<?php echo $key; ?>', '');<?php $closePHP; ?>" type="text">
                    </div>
                </div>
                <?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_STRING || $field['type'] == DB_FieldType::FIELD_TYPE_FLOAT){ ?>
                <!-- Вывод числовых+текстовых значений  -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="<?php echo $key; ?>">
                            <?php echo $field['title']; ?>

                        </label>
                        <input id="<?php echo $key; ?>" class="form-control" name="<?php echo $key; ?>" placeholder="счета" maxlength="20" value="<?php echo $openPHP; ?> echo htmlspecialchars(Arr::path($siteData->urlParams, '<?php echo $key; ?>', ''), ENT_QUOTES);<?php echo $closePHP; ?> " type="text">
                    </div>
                </div>
                <?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE_TIME) { ?>
                <!-- Дата и время  -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="<?php echo $key; ?>">
                            <?php echo $field['title']; ?>

                        </label>
                        <input name="<?php echo $key; ?>" type="datetime"  date-type="datetime"  class="form-control" placeholder=" <?php echo $field['title']; ?>" value="<?php echo $openPHP; ?> echo Arr::path($siteData->urlParams, '<?php echo $key; ?>', '');<?php echo $closePHP; ?>">
                    </div>
                </div>
                <?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE) { ?>
                <!-- Дата -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="<?php echo $key; ?>">
                            <?php echo $field['title']; ?>

                        </label>
                        <input name="<?php echo $key; ?>" type="datetime"  date-type="date"  class="form-control" placeholder=" <?php echo $field['title']; ?>" value="<?php echo $openPHP; ?>  echo Arr::path($siteData->urlParams, '<?php echo $key; ?>', '');<?php echo $closePHP; ?>">
                    </div>
                </div>
                <?php } } } ?>


                <div class="col-md-<?php echo $a; ?>">
                    <div hidden>
                        <?php echo $openPHP; ?> if($siteData->branchID > 0){ <?php echo $closePHP; ?>

                            <input name="shop_branch_id" value="<?php echo $openPHP; ?> echo $siteData->branchID; <?php echo $closePHP; ?>">
                        <?php echo $openPHP; ?> } <?php echo $closePHP; ?>


                        <?php echo $openPHP; ?> if(Arr::path($siteData->urlParams, 'is_public', '') == 1){<?php echo $closePHP; ?>

                            <input id="input-status" name="is_public" value="1">
                        <?php echo $openPHP; ?> }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){<?php echo $closePHP; ?>

                            <input id="input-status" name="is_not_public" value="1">
                        <?php echo $openPHP; ?> }elseif(Arr::path($siteData->urlParams, 'is_delete', '') == 1){<?php echo $closePHP; ?>

                            <input id="input-status" name="is_delete" value="1">
                        <?php echo $openPHP; ?> }else{<?php echo $closePHP; ?>

                            <input id="input-status" name="" value="1">
                        <?php echo $openPHP; ?> }<?php echo $closePHP; ?>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group pull-right">
                        <label for="input-limit-page">Кол-во записей</label>
                        <div class="input-group">
                            <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                <?php echo $openPHP; ?> $tmp = Request_RequestParams::getParamInt('limit_page'); <?php echo $closePHP; ?>

                                <option value="25" <?php echo $openPHP; ?> if(($tmp === NULL) || ($tmp == 25)){echo 'selected';} <?php echo $closePHP; ?>>25</option>
                                <option value="50" <?php echo $openPHP; ?> if($tmp == 50){echo 'selected';} <?php echo $closePHP; ?>>50</option>
                                <option value="100" <?php echo $openPHP; ?> if($tmp == 100){echo 'selected';} <?php echo $closePHP; ?>>100</option>
                                <option value="200" <?php echo $openPHP; ?> if($tmp == 200){echo 'selected';} <?php echo $closePHP; ?>>200</option>
                                <option value="500" <?php echo $openPHP; ?> if($tmp == 500){echo 'selected';} <?php echo $closePHP; ?>>500</option>
                                <option value="1000" <?php echo $openPHP; ?> if($tmp == 1000){echo 'selected';} <?php echo $closePHP; ?>>1000</option>
                                <option value="5000" <?php echo $openPHP; ?> if($tmp == 5000){echo 'selected';} <?php echo $closePHP; ?>>5000</option>
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