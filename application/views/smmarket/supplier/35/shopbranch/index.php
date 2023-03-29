<?php
$select = Request_RequestParams::getParamInt('partner');
$partnerStatus = intval(Arr::path($siteData->shop->getOptions(), 'partners_status.'.$data->id, '0'));
if(($select === NULL) || (($select == 1) && ($partnerStatus == 0)) || (($select == 2) && ($partnerStatus == 1)) || (($select == 3) && ($partnerStatus == 2))){
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td class="tr-header-photo">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 60); ?>" class="logo img-responsive" alt="">
    </td>
    <td><a href=""><?php echo $data->values['name']; ?></a></td>
    <td><a href=""><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_branch_catalog_id.name', ''); ?></a></td>
    <td>
        <ul class="list-inline tr-button <?php if($partnerStatus < 1){echo 'un-';}?>delete">
            <li class="tr-remove"><a href="/supplier/shopbranch/edit?id=<?php echo $data->id; ?>" class="link-blue text-sm"><i class="fa fa-plus-square"></i>подтвердить партнерство</a></li>
            <li class="tr-un-remove"><a href="/supplier/shopbranch/edit?id=<?php echo $data->id; ?>" class="link-red text-sm"><i class="fa fa-minus-square"></i>отменить партнерство</a></li>
        </ul>
    </td>
</tr>
<?php }?>