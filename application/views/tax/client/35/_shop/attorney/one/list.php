<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>">
    Доверенность №<?php
    echo $data->values['number'];
    if(!empty($data->values['date_from'])){
        echo ' от '.Helpers_DateTime::getDateFormatRus($data->values['date_from']);
    }
    if(!empty($data->values['name'])){
        echo ' на '.$data->values['name'];
    }
    ?>
</option>