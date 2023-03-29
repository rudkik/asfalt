<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>"
        data-human="<?php echo $data->values['human'];?>"
        data-human_extra="<?php echo $data->values['human_extra'];?>"
        data-price="<?php echo $data->values['price'];?>"
        data-price_extra="<?php echo $data->values['price_extra'];?>"
        data-price_child="<?php echo $data->values['price_child'];?>">
    <?php echo $data->values['name']. ' в ' . Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_building_id,.name', '');?>
</option>