<table id="panel-goods" data-id="<?php echo count($data['view::shopgood/promo']->childs); ?>"  class="table table-hover table-green">
    <thead>
    <tr>
        <th class="tr-header-number">Запуск</th>
        <th class="tr-header-number">Новинки</th>
        <th class="tr-header-id">ID</th>
        <th colspan="2" style="min-width: 200px">Товар</th>
        <th class="tr-header-amount">Цена</th>
        <th class="tr-header-rubric">Категория</th>
        <th class="tr-header-buttom-vertical"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::shopgood/promo']->childs as $value){
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php
            $view = View::factory('smmarket/sadmin/35/paginator');
            $view->siteData = $siteData;

            $urlParams = $siteData->urlParams;
            $urlParams['page'] = '-pages-';

            $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

            $view->urlData = $siteData->urlBasic.$siteData->url.$url;
            $view->urlAction = 'href';

            echo Helpers_View::viewToStr($view);
            ?>
        </div>
    </div>
</div>