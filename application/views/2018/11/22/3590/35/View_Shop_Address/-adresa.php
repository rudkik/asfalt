<div class="col-md-3">
    <?php
    $data->values['comment'] = '';
    echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', TRUE, true);
    ?>
</div>