<?php
for($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++){
    for($j = 1; $j < 4; $j++){
        switch ($j){
            case 1:
                $name = '_int';
                break;
            case 2:
                $name = '_float';
                break;
            case 3:
                $name = '_str';
                break;
            default:
                continue 2;
        }
        $name = 'param_'.$i.$name;
        ?>
        <?php if (Func::isShopMenu('shopcar/table/'.$name.'?type='.$type, $siteData)){ ?>
            <th class="tr-header-price">
                <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, $name); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.'.$name, SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, $name); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.'.$name, '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
    <?php } ?>
<?php }?>
