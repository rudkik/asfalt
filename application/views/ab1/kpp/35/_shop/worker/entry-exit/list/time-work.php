<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="text-left">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/time_work'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'); ?>" class="link-black">Работник</a>
        </th>
        <th class="text-left">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/time_work'). Func::getAddURLSortBy($siteData->urlParams, 'shop_department_id.name'); ?>" class="link-black">Отдел</a>
        </th>
        <th class="width-155 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/time_work'). Func::getAddURLSortBy($siteData->urlParams, 'late_for'); ?>" class="link-black">Опоздание</a>
        </th>
        <th class="width-155 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/time_work'). Func::getAddURLSortBy($siteData->urlParams, 'early_exit'); ?>" class="link-black">Уход раньше</a>
        </th>
        <th class="width-155">
            <a href="<?php echo Func::getFullURL($siteData, '/shopworkerentryexit/time_work'). Func::getAddURLSortBy($siteData->urlParams, 'time_work'); ?>" class="link-black">Отработанное время</a>
        </th>
    </tr>
    <tbody id="list" data-date="<?php echo date('d.m.Y H:i:s'); ?>">
    <?php
    foreach ($data['view::_shop/worker/entry-exit/one/time-work']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
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
<style>
    .blink {
        -webkit-animation: blink 1s linear infinite;
        animation: blink 1s linear infinite;
    }
    @-webkit-keyframes blink {
        100% { color: rgba(34, 34, 34, 0); }
    }
    @keyframes blink {
        100% { color: rgba(34, 34, 34, 0); }
    }
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>

<?php if(Request_RequestParams::getParamBoolean('is_exit') !== false
    && Request_RequestParams::getParamBoolean('is_delete') !== true) { ?>
<script async>
    $(function(){
        $('<audio id="chatAudio"><source src="<?php echo $siteData->urlBasic; ?>/css/ab1/audio/notify.ogg" type="audio/ogg"><source src="<?php echo $siteData->urlBasic; ?>/css/ab1/audio/notify.mp3" type="audio/mpeg"><source src="<?php echo $siteData->urlBasic; ?>/css/ab1/audio/notify.wav" type="audio/wav"></audio>').appendTo('body');
        var updateTable=function(){
            if($('#is_refresh').val() == 1) {
                jQuery.ajax({
                    url: '/kpp/shopworkerentryexit/time_work_new',
                    data: ({
                        _updated_at: ($('#list').data('date'))
                    }),
                    type: "GET",
                    success: function (data) {
                        var currentDate = new Date();
                        var currentDate = currentDate.toLocaleDateString() + ' ' + currentDate.toLocaleTimeString();
                        $('#list').html(data).data('date', currentDate);

                        if($('.blink').length > 0) {
                            $('#chatAudio')[0].play();
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }
            setTimeout(arguments.callee, 5000);
        }

        setTimeout(updateTable, 5000);
    });
</script>
<?php } ?>