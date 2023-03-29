<?php
$openPHP = '<?php';
$closePHP = '?>';
?>
<table class="table table-striped table-bordered table-hover">
    <tr>
        <?php foreach ($fieldsDB as $key => $field){ if (!empty($field['title'])) { if (!empty($field['table'])){ ?>
<th class="tr-header-rubric">
            <a href="<?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/index'). Func::getAddURLSortBy($siteData->urlParams, '<?php echo $key; ?>.name'); ?>" class="link-black"><?php echo $field['title']; ?></a>
        </th>
            <?php } elseif($field['type'] == DB_FieldType::FIELD_TYPE_BOOLEAN) { ?>
<th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo $openPHP; ?> Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/save');<?php echo $closePHP; ?>">
            </span>
        </th>
        <?php } else{?>
<th class="tr-header-rubric">
            <a href="<?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/index'). Func::getAddURLSortBy($siteData->urlParams, '<?php echo $key; ?>'); ?>" class="link-black"><?php echo $field['title']; ?></a>
        </th>
        <?php } } } ?>
<th class="tr-header-buttom"></th>
    </tr>
    <?php echo $openPHP; ?>

    foreach ($data['view::<?php echo $pathView; ?>/one/index']->childs as $value) {
        echo $value->str;
    }
    <?php echo $closePHP; ?>

</table>
<?php echo $openPHP; ?>

$view = View::factory('smg/_all/35/paginator');
$view->siteData = $siteData;

$urlParams = $siteData->urlParams;
$urlParams['page'] = '-pages-';

$shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
if($shopBranchID > 0) {
    $urlParams['shop_branch_id'] = $shopBranchID;
}

$url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

$view->urlData = $siteData->urlBasic.$siteData->url.$url;
$view->urlAction = 'href';

echo Helpers_View::viewToStr($view);
<?php echo $closePHP; ?>


