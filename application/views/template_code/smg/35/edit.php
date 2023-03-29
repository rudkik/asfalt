<?php
$openPHP = '<?php';
$closePHP = '?>';
?>


<div class="form-group"> <?php foreach ($fieldsDB as $key => $field){ if ($field['type'] == DB_FieldType::FIELD_TYPE_STRING){?>
    <!-- Вывод текстовые значений  -->
    <label class="col-md-2 control-label">
        <?php echo $field['title']; ?>

    </label>
    <div class="col-md-10">
        <input name="<?php echo $key; ?>" type="text" class="form-control" placeholder="<?php echo $field['title']; ?>" value="<?php echo $openPHP; ?> echo htmlspecialchars($data->values['<?php echo $key; ?>'], ENT_QUOTES); <?php echo $closePHP; ?>">
    </div><?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER){ if (!empty($field['table'])) { ?>
    <!-- Вывод списка выбора  -->
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo $field['title']; ?>

    </label>
    <div class="col-md-10">
        <select id="<?php echo $key; ?>" name="<?php echo $key; ?>" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $openPHP; ?> echo $siteData->globalDatas['view::<?php echo Api_MVC::pathView($key);?>/list/list']; <?php echo $closePHP; ?>

        </select>
    </div><?php  } else { ?>
    <!-- Вывод числовых значений  -->
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo $field['title']; ?>

    </label>
    <div class="col-md-10">
        <input name="<?php echo $key; ?>" type="phone" class="form-control" placeholder="<?php echo $field['title']; ?>" value="<?php echo $openPHP; ?> echo htmlspecialchars($data->values['<?php echo $key; ?>'], ENT_QUOTES); <?php echo $closePHP; ?>" >
    </div>
<?php } } if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE) { ?>
    <!-- Вывод даты  -->
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo $field['title']; ?>

    </label>
    <div class="col-md-10">
        <input name="<?php echo $key; ?>" type="datetime"  date-type="date"  class="form-control" placeholder="<?php echo $field['title']; ?>" value="<?php echo $openPHP; ?> echo htmlspecialchars($data->values['<?php echo $key; ?>'], ENT_QUOTES); <?php echo $closePHP; ?>" >
    </div>
<?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_BOOLEAN) { if ($key == 'is_public'){ ?>

            <label class="col-md-2 control-label"></label>
            <div class="col-md-10">
                <label class="span-checkbox">
                    <input name="is_public" value="0" style="display: none;">
                    <input name="is_public" <?php echo $openPHP; ?> if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; } <?php echo $closePHP; ?> type="checkbox" class="minimal">
                    Показать
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
    <div hidden>
        <?php echo $openPHP; ?> if($siteData->action != 'clone') { <?php echo $closePHP; ?>

            <input name="id" value="<?php echo $openPHP; ?> echo Arr::path($data->values, 'id', 0);<?php echo $closePHP; ?>">
        <?php echo $openPHP; ?> } <?php echo $closePHP; ?>

        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
