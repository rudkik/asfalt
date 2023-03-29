<?php
$openPHP = '<?php';
$closePHP = '?>';
?>
<tr>
    <?php foreach ($fieldsDB as $key => $field){ if (!empty($field['title'])){
    if ($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER && !empty($field['table'])){ ?><td><?php echo $openPHP; ?> echo $data->getElementValue('<?php echo $key; ?>', 'name'); <?php echo $closePHP; ?></td>
    <?php  } if ($field['type'] == DB_FieldType::FIELD_TYPE_STRING){?><td><?php echo $openPHP;?> echo $data->values['<?php echo $key; ?>']; <?php echo $closePHP; ?></td>
    <?php  } if ($field['type'] == DB_FieldType::FIELD_TYPE_DATE_TIME || $field['type'] == DB_FieldType::FIELD_TYPE_DATE || $field['type'] == DB_FieldType::FIELD_TYPE_TIME){?><td><?php echo $openPHP; ?> echo Helpers_DateTime::getDateTimeDayMonthRus($data->values['<?php echo $key; ?>']); <?php echo $closePHP; ?></td>
    <?php  } if ($field['type'] == DB_FieldType::FIELD_TYPE_FLOAT) { ?><td><?php echo $openPHP;?> echo $data->values['<?php echo $key; ?>']; <?php echo $closePHP; ?></td>
    <?php  } if ($field['type'] == DB_FieldType::FIELD_TYPE_BOOLEAN) {?><td>
        <input name="set-is-public" <?php echo $openPHP; ?> if ($data->values['<?php echo $key; ?>'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} <?php echo $closePHP; ?> href="<?php echo $closePHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/save', array('id' => 'id'), array(), $data->values); <?php echo $closePHP; ?>" type="checkbox" class="minimal" data-id="<?php echo $openPHP; ?> echo $data->id;<?php echo $closePHP;?>">
    </td>
    <?php  } } } ?>
<td>
        <ul class="list-inline tr-button <?php echo $openPHP;?> if ($data->values['is_delete'] == 1) { echo ' un-'; } <?php echo $closePHP; ?>delete">
            <li><a href="<?php echo $openPHP;?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/edit', array('id' => 'id'), array(), $data->values); <?php echo $closePHP; ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo $openPHP;?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/del', array('id' => 'id'), array(), $data->values); <?php echo $closePHP; ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo $openPHP;?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/del', array('id' => 'id'), array('is_undel' => 1), $data->values);  <?php echo $closePHP; ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
