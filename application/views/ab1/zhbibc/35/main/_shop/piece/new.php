<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/zhbibc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'ЖБИ и БС (добавление)'; ?>
                <form id="shoppiece" action="<?php echo Func::getFullURL($siteData, '/shoppiece/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/piece/one/new']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$view = View::factory('ab1/_all/35/_shop/client/one/modal');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/zhbibc/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
