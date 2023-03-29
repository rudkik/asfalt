<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/recorddb/index', array('db' => 'db'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Список записей</a></li>
        </ul>
    </td>
</tr>
