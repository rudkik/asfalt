    <?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', TRUE, FALSE); ?>
</p>
<div class="map">
    <script type="text/javascript" charset="utf-8" async src="<?php echo $data->values['map_data']; ?>"></script>
</div>