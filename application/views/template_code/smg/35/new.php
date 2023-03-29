<?php
$openPHP = '<?php';
$closePHP = '?>';
?>

<div class="form-group">
    <?php foreach ($fieldsDB as $key => $field){
        if ($field['type'] == DB_FieldType::FIELD_TYPE_STRING){?>

            <!-- Вывод текстовые значений  -->
            <label class="col-md-2 control-label">
                <?php echo $field['title']; ?>

            </label>
            <div class="col-md-10">
                <input name="<?php echo $key; ?>" type="text" class="form-control" placeholder="<?php echo $field['title']; ?>">
            </div>

        <?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER){ ?>

            <?php if (!empty($field['table'])) { ?>
                <!-- Вывод списка выбора  -->
                <label class="col-md-2 control-label">
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    <?php echo $field['title']; ?>

                </label>
                <div class="col-md-9">
                    <select id="<?php echo $key; ?>" name="<?php echo $key; ?>" class="form-control select2"  style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $openPHP; ?> echo $siteData->globalDatas['view::<?php echo Api_MVC::pathView($key);?>/list/list']; <?php echo $closePHP; ?>

                    </select>
                </div>
            <?php  } else { ?>
                <!-- Вывод числовых значений  -->
                <label class="col-md-2 control-label">
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    <?php echo $field['title']; ?>

                </label>
                <div class="col-md-10">
                    <input name="<?php echo $key; ?>" type="phone" class="form-control" placeholder="<?php echo $field['title']; ?>">
                </div>
            <?php } } if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE) { ?>
            <!-- Вывод даты  -->
            <label class="col-md-2 control-label">
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo $field['title']; ?>

            </label>
            <div class="col-md-10">
                <input name="<?php echo $key; ?>" type="datetime"  date-type="date"  class="form-control" placeholder="<?php echo $field['title']; ?>">
            </div>

            <?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_BOOLEAN){ if($key == 'is_public'){ ?>
            <label class="col-md-2 control-label">Показать</label>
            <div class="col-md-10">
                <label class="span-checkbox">
                    <input name="is_public" value="0" style="display: none">
                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                    
                </label>
            </div>
            <?php } } if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE_TIME) { ?>
            <!-- Вывод даты  -->
            <label class="col-md-2 control-label">
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo $field['title']; ?>

            </label>
            <div class="col-md-10">
                <input name="<?php echo $key; ?>" type="datetime"  date-type="datetime"  class="form-control" placeholder="<?php echo $field['title']; ?>" >
            </div>
        <?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_TIME) { ?>
            <!-- Вывод даты  -->
            <label class="col-md-2 control-label">
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo $field['title']; ?>

            </label>
            <div class="col-md-10">
                <input name="<?php echo $key; ?>" type="datetime"  date-type="time"  class="form-control" placeholder="<?php echo $field['title']; ?>" >
            </div>
        <?php } } ?>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>