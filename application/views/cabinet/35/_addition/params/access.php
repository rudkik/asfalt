<?php
/**
 * @param $objectName - название объекта (например: shop_car, shop_table_brand) (обязательно поле)
 * @param $where - куда размещать:
 * для редактирвоание - пустое значение,
 * для поиска - find,
 * для таблице в списке - table
 */
if(empty($where)){
    $where = '';
}else{
    $where = '/'.$where;
}
$fields = Arr::path($data->values, 'fields_params.'.$objectName);
if(! is_array($fields)){
    $fields = array();
}
$objectName = str_replace('_', '', $objectName);
foreach ($fields as $field){
    switch (Arr::path($field, 'type', 0)){
        case Model_Shop_Table_Basic_Table::PARAM_TYPE_INT:
            $name = '_int';
            break;
        case Model_Shop_Table_Basic_Table::PARAM_TYPE_FLOAT:
            $name = '_float';
            break;
        case Model_Shop_Table_Basic_Table::PARAM_TYPE_STR:
            $name = '_str';
            break;
        default:
            continue 2;
    }
    $name = 'param_'.$field['field'].$name;
    ?>
    <?php $key = $objectName.$where.'/'.$name.'?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            <?php echo $field['title']; ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php }?>