<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>">
    №<?php echo $data->values['number'];?>
    от <?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']);?>
    на <?php echo htmlspecialchars($data->values['client_name'], ENT_QUOTES) ;?>
</option>