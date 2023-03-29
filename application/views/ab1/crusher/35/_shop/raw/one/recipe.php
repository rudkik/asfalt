<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td class="text-right"><?php echo $data->values['count_recipe']; ?></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopraw/raw_recipe', array(), array('id' => $data->id), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Рецепты</a></li>
        </ul>
    </td>
</tr>
