<tr data-barcode="<?php echo $data->getElementValue('shop_product_id', 'barcode'); ?>" data-action="tr">
    <td data-id="index" class="text-right">$index$</td>
    <td>
        <a target="_blank" href="/accounting/shopproduct/edit?id=<?php echo $data->values['shop_product_id']; ?>"><?php echo $data->getElementValue('shop_product_id'); ?></a>
        <br><span data-id="barcode"><?php echo $data->getElementValue('shop_product_id', 'barcode'); ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right">
        <input data-action="save-db" name="coefficient_revise" type="text"  class="form-control"
               value="<?php echo $data->getElementValue('shop_product_id', 'coefficient_revise'); ?>"
               data-url="<?php echo Func::getFullURL($siteData, '/shopproduct/save_coefficient', array(), array('id' => $data->values['shop_product_id']), $data->values); ?>">
    </td>
    <td>
        <select data-action="save-db" data-type="select2" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;"
                data-url="<?php echo Func::getFullURL($siteData, '/shopproduct/save_coefficient', array(), array('id' => $data->values['shop_product_id']), $data->values); ?>">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.$data->getElementValue('shop_product_id', 'shop_product_rubric_id').'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/rubric/list/list']);
            ?>
        </select>
    </td>
    <td>
        <select data-action="save-db" data-type="select2" name="unit_id" class="form-control select2" required style="width: 100%;"
                data-url="<?php echo Func::getFullURL($siteData, '/shopproduct/save_coefficient', array(), array('id' => $data->values['shop_product_id']), $data->values); ?>">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.$data->getElementValue('shop_product_id', 'unit_id').'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::unit/list/list']);
            ?>
        </select>
    </td>
    <td>
        <a target="_blank" href="/accounting/shopproduction/edit?id=<?php echo $data->getElementValue('shop_production_id', 'id'); ?>"><?php echo $data->getElementValue('shop_production_id'); ?></a>
        <br><span data-id="barcode"><?php echo $data->getElementValue('shop_production_id', 'barcode'); ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->getElementValue('shop_production_id', 'price'), TRUE, 2, FALSE); ?></td>
    <td class="text-right">
        <input data-action="save-db" name="weight_kg" type="text"  class="form-control"
               value="<?php echo $data->getElementValue('shop_production_id', 'weight_kg'); ?>"
               data-url="<?php echo Func::getFullURL($siteData, '/shopproduction/save_coefficient', array(), array('id' => $data->getElementValue('shop_production_id', 'id')), $data->values); ?>">
    </td>
    <td class="text-right">
        <input data-action="save-db" name="coefficient_rubric" type="text"  class="form-control"
               value="<?php echo $data->getElementValue('shop_production_id', 'coefficient_rubric'); ?>"
               data-url="<?php echo Func::getFullURL($siteData, '/shopproduction/save_coefficient', array(), array('id' => $data->getElementValue('shop_production_id', 'id')), $data->values); ?>">
    </td>
    <td class="text-right">
        <input data-action="save-db" name="coefficient" type="text"  class="form-control"
               value="<?php echo $data->getElementValue('shop_production_id', 'coefficient'); ?>"
               data-url="<?php echo Func::getFullURL($siteData, '/shopproduction/save_coefficient', array(), array('id' => $data->getElementValue('shop_production_id', 'id')), $data->values); ?>">
    </td>
    <td>
        <select data-action="save-db" data-type="select2" name="shop_production_rubric_id" class="form-control select2" required style="width: 100%;"
                data-url="<?php echo Func::getFullURL($siteData, '/shopproduction/save_coefficient', array(), array('id' => $data->getElementValue('shop_production_id', 'id')), $data->values); ?>">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.$data->getElementValue('shop_production_id', 'shop_production_rubric_id').'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/production/rubric/list/list']);
            ?>
        </select>
    </td>
    <td>
        <select data-action="save-db" data-type="select2" name="unit_id" class="form-control select2" required style="width: 100%;"
                data-url="<?php echo Func::getFullURL($siteData, '/shopproduction/save_coefficient', array(), array('id' => $data->getElementValue('shop_production_id', 'id')), $data->values); ?>">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.$data->getElementValue('shop_production_id', 'unit_id').'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::unit/list/list']);
            ?>
        </select>
    </td>
</tr>