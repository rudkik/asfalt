<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <?php
        if(!is_array($data->values['options'])) {
            $data->values['options'] = json_decode($data->values['options'], true);
        }
        if(is_array($data->values['options'])) {
            foreach ($data->values['options'] as $view) {
                foreach ($view as $contract) {
                    ?>
                    <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/save_word', array(), array('id' => 0, 'file' => $contract['file'], 'is_not_replace' => true)); ?>" class="btn bg-blue btn-flat" style="margin-right: 10px"><?php echo $contract['title']; ?></a>
                    <?php
                }
            }
        }
        ?>
    </td>
    <td>
    </td>
</tr>
