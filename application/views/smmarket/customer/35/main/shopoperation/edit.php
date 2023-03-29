<?php
$view = View::factory($siteData->shopShablonPath.'/35/find');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<div class="body-manager-shop">
    <div class="container">
        <h1>Менеджер</h1>
        <div class="row">
            <div class="box-body" style="max-width: 500px">
                <form class="form" style="padding:10px;" id="users-form" action="/customer/shopoperation/save" method="post">
                    <?php echo trim($data['view::shopoperation/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>