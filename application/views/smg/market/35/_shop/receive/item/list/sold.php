<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'shop_company_id.name'); ?>" class="link-black">Компания</a>
        </th>
        <th class="width-100" style="font-size: 11px">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'shop_receive_id.number'); ?>" class="link-black">№ накладная</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'shop_receive_id.date'); ?>" class="link-black">Дата накладная</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
        </th>
        <th class="text-right width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.article'); ?>" class="link-black">Артикул</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Название</a>
        </th>
        <th class="text-right width-70">
            <a href="<?php echo Func::getFullURL($siteData, '/shopreceiveitem/sold'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_sales'); ?>" class="link-black">Кол-во</a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/receive/item/one/sold']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php
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
?>
<style>
    .h_i_g_h {
        background-color: #C6D9DB;
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function () {
        function findSelect(parent) {
            var receive = parent.find('[data-id="receive"]');
            var product = parent.find('[data-id="product"]');

            if(product.length == 0){
                return;
            }

            // удаляем подстветку
            receive.find('span.h_i_g_h').each(function(){
                $(this).after($(this).html()).remove();
            });
            receive.find('.h_i_g_h').each(function(){
                $(this).removeClass('h_i_g_h');
            });
            product.find('span.h_i_g_h').each(function(){
                $(this).after($(this).html()).remove();
            });
            product.find('.h_i_g_h').each(function(){
                $(this).removeClass('h_i_g_h');
            });

            var textProduct = $.trim(product.text());
            var textReceive = $.trim(receive.text());

            if(textProduct == textReceive) {
                receive.html('<span class="h_i_g_h">' + receive.html() + '</span>');
                product.html('<span class="h_i_g_h">' + product.html() + '</span>');

                return;
            }

            if(textProduct != '') {
                // разбитие по словам
                var words = textProduct.split(/[\s|,!#\"]/);
                // поиск по названию
                $.each(words, function (index, term) {
                    if (term.length > 2) {
                        term = term
                            .replace(/\\/g, '\\')
                            .replace(/\//g, '\\/')
                            .replace(/\[/g, '\\[')
                            .replace(/\]/g, '\\]')
                            .replace(/\(/g, '\\(')
                            .replace(/\)/g, '\\)')
                            .replace(/\{/g, '\\{')
                            .replace(/\}/g, '\\}')
                            .replace(/\?/g, '\\?')
                            .replace(/\+/g, '\\+')
                            .replace(/\*/g, '\\*')
                            .replace(/\|/g, '\\|')
                            .replace(/\./g, '\\.')
                            .replace(/\^/g, '\\^')
                            .replace(/\$/g, '\\$');

                        receive.html(receive.html().replace(new RegExp(term, 'ig'), '<span class="h_i_g_h">$&</span>'));
                    }else{
                        if (term.length == 2) {
                            receive.html(receive.html().replace(new RegExp(' ' + term + ' ', 'ig'), '<span class="h_i_g_h">$&</span>'));
                            receive.html(receive.html().replace(new RegExp(term + ' ', 'ig'), '<span class="h_i_g_h">$&</span>'));
                            receive.html(receive.html().replace(new RegExp(' ' + term + ' ', 'ig'), '<span class="h_i_g_h">$&</span>'));
                        }else {
                            receive.html(receive.html().replace(new RegExp(' ' + term + ' ', 'ig'), '<span class="h_i_g_h">$&</span>'));
                        }
                    }
                });
            }

            if(textReceive != '') {
                // разбитие по словам
                var words = textReceive.split(/[\s|,!#\"]/);
                // поиск по названию
                $.each(words, function (index, term) {
                    if (term.length > 2) {
                        term = term
                            .replace(/\\/g, '\\')
                            .replace(/\//g, '\\/')
                            .replace(/\[/g, '\\[')
                            .replace(/\]/g, '\\]')
                            .replace(/\(/g, '\\(')
                            .replace(/\)/g, '\\)')
                            .replace(/\{/g, '\\{')
                            .replace(/\}/g, '\\}')
                            .replace(/\?/g, '\\?')
                            .replace(/\+/g, '\\+')
                            .replace(/\*/g, '\\*')
                            .replace(/\|/g, '\\|')
                            .replace(/\./g, '\\.')
                            .replace(/\^/g, '\\^')
                            .replace(/\$/g, '\\$');

                        product.html(product.html().replace(new RegExp(term, 'ig'), '<span class="h_i_g_h">$&</span>'));
                    }else{
                        if (term.length == 2) {
                            product.html(product.html().replace(new RegExp(' ' + term + ' ', 'ig'), '<span class="h_i_g_h">$&</span>'));
                            product.html(product.html().replace(new RegExp(term + ' ', 'ig'), '<span class="h_i_g_h">$&</span>'));
                            product.html(product.html().replace(new RegExp(' ' + term, 'ig'), '<span class="h_i_g_h">$&</span>'));
                        }else {
                            product.html(product.html().replace(new RegExp(' ' + term + ' ', 'ig'), '<span class="h_i_g_h">$&</span>'));
                        }
                    }
                });
            }
        }

        $('[data-id="receive"], [data-id="product"]').on('mouseup', function(){
            findSelect($(this).closest('tr'));
        }).on('dblclick', function(){
            findSelect($(this).closest('tr'));
        });

        $('[data-id="receive"]').trigger('mouseup');
    });
</script>
