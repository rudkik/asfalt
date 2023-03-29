
<tr>
    <td class="text-right"><?php echo $data->values['id']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_analysis_place_id'); ?></td>
    <?php  foreach ($data->values['options'] as $value ){ ?>
        <?php if (gettype($value) != 'array'){
            ?><td><?php
            echo $value;
            ?></td><?php
        }else{
            foreach ($value as $key2 => $value2){
                ?><td><?php
                if ($key2 == 'value'){
                    foreach ($value2 as $value3){
                        echo $value3 . '<br>';
                    }
                }else{
                    echo $value2;
                }
                ?></td><?php
        }
        }?>
    <?php } ?>
    <td><?php echo $data->getElementValue('shop_worker_id'); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopanalysis/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopanalysis/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopanalysis/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
