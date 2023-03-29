<?php
if(empty($optionsName)){
    $optionsName = 'image_types';
}
if(key_exists($optionsName, $data->values)) {
    $listOption = $data->values[$optionsName];
}else{
    $listOption = array();
}

if(!empty($optionsChild)) {
    if (key_exists($optionsChild, $listOption)) {
        $listOption = $listOption[$optionsChild];
    }else{
        $listOption = array();
    }
    $childName = '[' . $optionsChild . ']';
}else{
    $childName = '';
    $optionsChild = '';
}
?>
<input name="<?php echo $optionsName.$childName;?>[-5000]" style="display: none;">
<table id="body_panel_image-<?php echo $optionsChild;?>" data-id="<?php echo count($listOption); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <th>
            Заголовок
        </th>
        <th>
            Название <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-buttom-delete"></th>
    </tr>
    <?php foreach ($listOption as $index => $value){ ?>
        <tr>
            <td><input name="<?php echo $optionsName.$childName;?>[<?php echo $index;?>][title]" type="text" class="form-control" value="<?php echo htmlspecialchars($value['title'], ENT_QUOTES);?>"></td>
            <td><input name="<?php echo $optionsName.$childName;?>[<?php echo $index;?>][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);?>"></td>
            <td>
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        </tr>
    <?php } ?>
</table>
<?php if (count($listOption) == 0){ ?>
    <div id="div-not-image-options-<?php echo $optionsChild;?>" class="contacts-list-msg text-center margin-b-5">Виды изображения не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_image-<?php echo $optionsChild;?>', 'tr_panel_image-<?php echo $optionsChild;?>', 'div-not-image-options-<?php echo $optionsChild;?>')"><i class="fa fa-fw fa-plus"></i> Добавить вид картинки</button>
</div>

<div hidden="hidden" id="tr_panel_image-<?php echo $optionsChild;?>">
<!--
<tr>
    <td><input name="<?php echo $optionsName.$childName;?>[#index#][title]" type="text" class="form-control"></td>
    <td><input name="<?php echo $optionsName.$childName;?>[#index#][name]" type="text" class="form-control"></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
 -->
</div>
