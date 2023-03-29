<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>"><?php
    echo $data->values['name'];

    $s = $data->values['barcode'];
    if(!empty($s)){
        echo ' ('.$s.')';
    }

    $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', '');
    if(!empty($s)){
        echo ' - склад ' . $s;
    }
    ?></option>