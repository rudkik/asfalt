<tr>
    <td>
        <?php
        for ($i = 0; $i < $data->values['level']; $i++){
            echo '--';
        }
        ?>
        <?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?>
    </td>
    <td><?php echo $data->getElementValue('shop_material_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_subdivision_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_heap_id'); ?></td>
    <td>
        <?php if($data->values['shop_formula_material_id'] > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopformulamaterial/edit', array(), array('id' => $data->values['shop_formula_material_id'])); ?>"><?php echo $data->getElementValue('shop_formula_material_id'); ?></a>
        <?php }elseif($data->values['shop_formula_product_id'] > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/edit', array(), array('id' => $data->values['shop_formula_product_id'])); ?>"><?php echo $data->getElementValue('shop_formula_product_id'); ?></a>
        <?php }else{ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopformularaw/edit', array(), array('id' => $data->values['shop_formula_raw_id'])); ?>"><?php echo $data->getElementValue('shop_formula_raw_id'); ?></a>
        <?php } ?>
    </td>
    <td class="text-right"><?php echo $data->values['level']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
</tr>
<?php
foreach ($data->childs as $child){
    $view = View::factory('ab1/abc/35/_shop/register/material/one/tree');
    $view->siteData = $siteData;
    $view->data = $child;
    echo Helpers_View::viewToStr($view);
}
?>