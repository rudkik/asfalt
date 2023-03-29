<?php
$openPHP = '<?php';
$closePHP = '?>';
?>
<!-- Вывод чекбокс c галочкой  -->
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<?php foreach ($fieldsDB as $key => $field){ if (!empty($field['title'])){
    if ($field['type'] == DB_FieldType::FIELD_TYPE_STRING){?>
<div class="row record-input record-list">
    <!-- Вывод текстовые значений  -->
    <div class="col-md-3 record-title">
        <label>
            <?php echo $field['title']; ?>

        </label>
    </div>
    <div class="col-md-3">
        <input name="<?php echo $key; ?>" type="text" class="form-control" placeholder="<?php echo $field['title']; ?>">

    </div>
</div>
<?php } if ($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER){ ?>
<div class="row record-input record-list">
    <?php if (!empty($field['table'])) { ?>
    <!-- Вывод списка выбора  -->
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo $field['title']; ?>

        </label>
    </div>
    <div class="col-md-9">
        <select id="<?php echo $key; ?>" name="<?php echo $key; ?>" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $openPHP; ?> echo $siteData->globalDatas['view::<?php echo Api_MVC::pathView($key); ?>/list/list']; <?php echo $closePHP; ?>

        </select>
    </div>
    <? } else { ?>
    <!-- Вывод числовых значений  -->
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
           <?php echo $field['title']; ?>

        </label>
    </div>
    <div class="col-md-3">
        <input name="<?php echo $key; ?>" type="phone" class="form-control" placeholder="Вес" required>
    </div>
        <?php } } ?>
</div>
<?php if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE) { ?>
<div class="row record-input record-list">
    <!-- Вывод даты  -->
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo $field['title']; ?>

        </label>
    </div>
    <div class="col-md-3">
        <input name="<?php echo $key; ?>" type="datetime"  date-type="date"  class="form-control" placeholder="<?php echo $field['title']; ?>" required>
    </div>

</div>
<?php } ?>
<?php if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE_TIME) { ?>
    <div class="row record-input record-list">
        <!-- Вывод даты  -->
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo $field['title']; ?>

            </label>
        </div>
        <div class="col-md-3">
            <input name="<?php echo $key; ?>" type="datetime"  date-type="datetime"  class="form-control" placeholder="<?php echo $field['title']; ?>" required>
        </div>
    </div>
<?php } ?>
<?php if ($field['type'] == DB_FieldType::FIELD_TYPE_TIME) { ?>
    <div class="row record-input record-list">
        <!-- Вывод даты  -->
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo $field['title']; ?>

            </label>
        </div>
        <div class="col-md-3">
            <input name="<?php echo $key; ?>" type="datetime"  date-type="time"  class="form-control" placeholder="<?php echo $field['title']; ?>" required>
        </div>
    </div>
<?php } ?>
<?php } } ?>

<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
