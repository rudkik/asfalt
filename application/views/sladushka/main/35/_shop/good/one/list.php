<option value="<?php echo $data->values['id'];?>"
        data-id="<?php echo $data->values['id'];?>"
        data-price="<?php echo $data->values['price'];?>"
data-weight="<?php echo floatval(Arr::path($data->values['options'], 'weight', 0)); ?>">
    <?php echo $data->values['name']; ?>
</option>