<table id="example2_wrapper" class="table table-bordered table-hover table-striped dataTable no-footer">
    <thead>
    <tr>
        <th style="text-align: left; position: relative; padding: 8px; width: 20px;">
            <label>
                <input type="checkbox" class="flat-red" checked>
            </label>
        </th>
        <th>Тип e-mail</th>
        <th style="width: 183px; text-align: left; position: relative; padding: 8px;"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>...</td>
        <td>...</td>
        <td>
            <a buttom_list="new" href="<?php echo $siteData->urlBasic.'/cabinet/shopemail/new';?><?php if($siteData->branchID > 0){echo '?shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-default btn-sm checkbox-toggle">добавить</a>
        </td>
    </tr>
    <?php
    foreach ($data['view::shopemail/index']->childs as $value){
        echo $value->str;
    }
    ?>
    </tbody>
</table>

<?php
$view = View::factory('cabinet/35/paginator');
$view->siteData = $siteData;

$urlParams = $siteData->urlParams;
$urlParams['page'] = '-pages-';

$shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
if($shopBranchID > 0) {
    $urlParams['shop_branch_id'] = $shopBranchID;
}

$url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

$view->urlData = 'actionTableFind(\''.$siteData->urlBasic.$siteData->url.$url.'\', \'\', \'table_panel\')';
$view->urlAction = 'onclick';

echo Helpers_View::viewToStr($view);
?>

