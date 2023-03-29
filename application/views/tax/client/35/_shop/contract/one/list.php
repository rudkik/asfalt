<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>">
    Договор №<?php
    echo $data->values['number'];
    if(!empty($data->values['date_from'])){
        echo ' от '.Helpers_DateTime::getDateFormatRus($data->values['date_from']);
    }
    ?>
</option>