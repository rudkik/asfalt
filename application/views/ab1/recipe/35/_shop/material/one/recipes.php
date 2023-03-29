<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['name_recipe']; ?></td>
    <td><?php echo $data->getElementValue('shop_material_rubric_id'); ?></td>
    <td><?php echo $data->values['unit']; ?></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a target="_blank" target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopmaterial/material_recipe', array(), array('id' => $data->id), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Рецепты</a></li>
        </ul>
    </td>
</tr>
