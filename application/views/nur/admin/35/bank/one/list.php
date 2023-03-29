<option value="<?php echo $data->values['id'];?>"
        data-id="<?php echo $data->values['id'];?>"
        data-bik="<?php echo htmlspecialchars($data->values['bik'], ENT_QUOTES);?>"
        data-name="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    <?php echo $data->values['name']; ?> - <?php echo $data->values['bik']; ?>
</option>