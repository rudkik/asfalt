<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>">
    Доверенность №<?php
    echo $data->values['number'];
    if(!empty($data->values['date_from'])){
        echo ' от '.Helpers_DateTime::getDateFormatRus($data->values['date_from']);
    }
    $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', '');
    if(!empty($s)){
        echo ' на '.$s;
    }
    ?>
</option>