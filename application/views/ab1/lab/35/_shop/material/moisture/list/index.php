<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            Поставщик
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a> /

            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th class="width-90 text-right"">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/index'). Func::getAddURLSortBy($siteData->urlParams, 'moisture'); ?>" class="link-black">Влажность</a>
        </th>
        <th class="width-90 text-right"">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/index'). Func::getAddURLSortBy($siteData->urlParams, 'density'); ?>" class="link-black">Плотность</a>
        </th>
        <th class="width-130 text-right"">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Тоннаж за сутки</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/material/moisture/one/index']->childs as $value) {
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

<script>
    $('[data-action="calc-stock"]').click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href');
        var el = $(this).parents('tr').find('[data-id="stock"]');

        jQuery.ajax({
            url: url,
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                el.htmlNumber(obj.quantity, 3);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });

    $('[data-action="update-moisture"]').click(function (e) {
        e.preventDefault();

        $('#modal-moisture').modal('show');

        $('#modal-moisture [name="id"]').val($(this).data('id'));
        $('#modal-moisture [name="moisture"]').val($(this).data('moisture'));
    });
    
    function saveMoisture() {
        var form = $('#modal-moisture form');
        var url = form.attr('action');

        var formData = form.serialize();
        formData = formData + '&json=1';

        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                $('a[data-id="'+obj.values.id+'"]').text(obj.values.moisture).data('moisture', obj.values.moisture);
                $('#modal-moisture').modal('hide');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

</script>

<div id="modal-moisture" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить влажности</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/save'); ?>" class="modal-fields">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Влажность
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input data-type="money" data-fractional-length="2" name="moisture" type="text" class="form-control" placeholder="Влажность">
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <input name="id" value="" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="saveMoisture();">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>