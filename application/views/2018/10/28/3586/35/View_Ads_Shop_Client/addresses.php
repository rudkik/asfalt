<div class="dropdown field dropdown--full dropdown--invert">
    <select data-id="address" class="dropdown__current__wrap">
        <?php $addresses = $data->values['addresses']; ?>
        <?php if (count($addresses) > 0){  ?>
            <?php foreach ($addresses as $address){ ?>
                <?php
                $s = Arr::path($address, 'land_name', '').', '
                    . Arr::path($address, 'city_name', '').', '
                    . Arr::path($address, 'address', '');
                ?>
                <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
            <?php } ?>
        <?php }else{ ?>
            <option disabled>Необходимо добавить адрес</option>
        <?php } ?>
    </select>
</div>