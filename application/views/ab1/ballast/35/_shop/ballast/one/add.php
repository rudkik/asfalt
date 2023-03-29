<div class="row">
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <div class="col-md-2">
            <label>
                Дата
            </label>
            <input id="date" name="date" type="datetime" date-type="datetime" class="form-control"  value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Request_RequestParams::getParamDateTime('date')); ?>">
        </div>
    <?php } ?>
    <div class="col-md-3">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Откуда
        </label>
        <select id="take_shop_ballast_crusher_id" name="take_shop_ballast_crusher_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">С карьера</option>
            <?php
            $tmp = 'data-id="'.Request_RequestParams::getParamInt('take_shop_ballast_crusher_id').'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/ballast/crusher/list/list']);
            ?>
        </select>
    </div>
    <div class="col-md-3">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место погрузки
        </label>
        <select id="shop_ballast_distance_id" name="shop_ballast_distance_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php
            $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_ballast_distance_id').'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/ballast/distance/list/list']);
            ?>
        </select>
    </div>
    <div class="col-md-3">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Смена
        </label>
        <select id="shop_work_shift_id" name="shop_work_shift_id" class="form-control select2" required style="width: 100%;">
            <option value="-1" data-id="-1">Без значения</option>
            <?php
            $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_work_shift_id').'"';
            echo str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/work/shift/list/list']);
            ?>
        </select>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#date, [name="shop_work_shift_id"]').change(function () {
            window.location.href = '<?php echo $siteData->urlBasic;?>/ballast/shopballast/add?shop_work_shift_id='
                + $('#shop_work_shift_id').val()
                + '&shop_ballast_distance_id='+$('#shop_ballast_distance_id').val()
                + '&take_shop_ballast_crusher_id='+$('#take_shop_ballast_crusher_id').val()
                + '&date='+$('#date').val();
        })
    });
</script>
<?php echo $siteData->globalDatas['view::_shop/ballast/car/to/driver/list/add-ballast']; ?>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = array_merge($siteData->urlParams, $_GET, $_POST);
    $urlParams['page'] = '-pages-';

    $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
    if($shopBranchID > 0) {
        $urlParams['shop_branch_id'] = $shopBranchID;
    }

    $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

    $view->urlData = $siteData->urlBasic.$siteData->url.$url;
    $view->urlAction = 'href';

    echo Helpers_View::viewToStr($view);
    ?>
</div>

