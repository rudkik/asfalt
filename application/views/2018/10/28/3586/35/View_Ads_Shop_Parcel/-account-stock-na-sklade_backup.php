<div class="package row">
    <div class="col-sm-12">
    <div class="package__preview">
        <div class="package__check" style="display: none">
            <input id="package-1" type="checkbox" class="field--checkbox">
            <label for="package-1" class="field--checkbox__label field--checkbox__label--mr"></label>
        </div>
        <div class="package__img" style="background-image: url('<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 200, 200, $siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/box.jpg'); ?>');"></div>
    </div>
    <table class="package__table table--clear">
        <thead class="table--clear__head">
        <tr class="table--clear__row">
            <td class="table--clear__col">Посылка:</td>
            <td class="table--clear__col">№<?php echo $data->values['id'];?></td>
        </tr>
        </thead>
        <tbody class="table--clear__body">
        <tr class="table--clear__row">
            <td class="table--clear__col">Магазин:</td>
            <td class="table--clear__col"><?php echo $data->values['shop_name'];?></td>
        </tr>
        <tr class="table--clear__row">
            <td class="table--clear__col">Дата получения:</td>
            <td class="table--clear__col"><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_receipt_at']);?></td>
        </tr>
        <tr class="table--clear__row">
            <td class="table--clear__col">Вес:</td>
            <td class="table--clear__col"><?php echo floatval($data->values['weight']);?> кг</td>
        </tr>
        </tbody>
    </table>
    </div>
    <div class="col-sm-12" data-id="address_id" data-value="<?php echo $data->values['id'];?>">
    <?php
    $s = 'value="'.$data->values['address'].'"';
    echo str_replace($s, $s.'selected', $siteData->replaceDatas['view::View_Ads_Shop_Client\addresses']);
    ?>
    </div>
</div>