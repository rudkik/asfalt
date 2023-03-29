<tr>
    <?php foreach ($data->additionDatas['fields'] as $name => $field) { ?>
        <?php if($field['type'] == DB_FieldType::FIELD_TYPE_INTEGER){ ?>
            <?php if(!key_exists('table', $field) || !$field['table']::IS_CATALOG || key_exists('name', $field['table']::FIELDS)){?>
                <td>
                    <?php echo $data->getElementValue($name, 'name', $data->values[$name]); ?>
                </td>
            <?php }else{ ?>
                <td class="text-right">
                    <?php echo $data->values[$name]; ?>
                </td>
            <?php }?>
        <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_FLOAT){ ?>
            <td class="text-right">
                <?php echo $data->values[$name]; ?>
            </td>
        <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_BOOLEAN){ ?>
            <td>
                <input <?php if ($data->values[$name] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" disabled>
            </td>
        <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_DATE_TIME){ ?>
            <td>
                <?php echo Helpers_DateTime::getDateTimeFormatRus($data->values[$name]); ?>
            </td>
        <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_DATE){ ?>
            <td>
                <?php echo Helpers_DateTime::getDateFormatRus($data->values[$name]); ?>
            </td>
        <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_TIME){ ?>
            <td>
                <?php echo Helpers_DateTime::getTimeFormatRus($data->values[$name]); ?>
            </td>
        <?php }elseif($field['type'] == DB_FieldType::FIELD_TYPE_STRING){ ?>
            <td>
                <?php echo $data->values[$name]; ?>
            </td>
        <?php } ?>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/recorddb/edit', array('id' => 'id', 'db' => 'db'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <?php if($data->id > 100){?>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/recorddb/del', array('id' => 'id', 'db' => 'db'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/recorddb/del', array('id' => 'id', 'db' => 'db'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php }?>
        </ul>
    </td>
</tr>
