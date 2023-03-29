<div class="tab-pane active">
    <?php $siteData->titleTop = $data['view::record-db/one/index']->additionDatas['name']; ?>
    <?php
    $view = View::factory('ab1/admin/35/main/record-db/filter/index');
    $view->siteData = $siteData;
    $view->data = $data['view::record-db/one/index'];
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/recorddb/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/recorddb/index', array(), array('is_not_public' => 1));?>" data-id="is_not_public">Неактивные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/recorddb/index', array(), array('is_public' => 1));?>" data-id="is_public">Активные</a></li>
        <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/recorddb/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
    </ul>
</div>
<div class="body-table">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <table class="table table-hover table-db table-tr-line" data-action="fixed">
            <tr>
                <?php $data = $data['view::record-db/one/index']; ?>
                <?php foreach ($data->additionDatas['fields'] as $name => $field) { ?>
                    <th>
                        <a href="<?php echo Func::getFullURL($siteData, '/record-db/index'). Func::getAddURLSortBy($siteData->urlParams, $name); ?>" class="link-black"><?php if(empty($field['title'])){ echo $name; }else{ echo $field['title'];} ?></a>
                    </th>
                <?php } ?>
                <th class="tr-header-buttom"></th>
            </tr>
            <?php
            foreach ($data->childs as $value) {
                echo $value->str;
            }
            ?>
        </table>
        <div class="col-md-12 padding-top-5px">
            <?php
            $view = View::factory('ab1/_all/35/paginator');
            $view->siteData = $siteData;

            $urlParams = array_merge($siteData->urlParams, $_GET, $_POST);
            $urlParams['page'] = '-pages-';

            $shopBranchID =intval( Request_RequestParams::getParamInt('shop_branch_id'));
            if($shopBranchID > 0) {
                $urlParams['shop_branch_id'] = $shopBranchID;
            }

            $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

            $view->urlData = $siteData->urlBasic.$siteData->url.$url;
            $view->urlAction = 'href';

            echo Helpers_View::viewToStr($view);
            ?>
        </div>
    </div>
</div>
<style>
    .icheckbox_minimal-blue.checked.disabled {
        background-position: -40px 0 !important;
    }
</style>