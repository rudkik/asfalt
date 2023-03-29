<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/cash/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <?php if($siteData->operation->getShopTableUnitID()){ ?>
                <h3>Отгружено объемов ЖБИ и БС</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products_volume'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_id_product_volume">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_id_product_volume" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                            <script>
                                var bestPictures = new Bloodhound({
                                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                                    remote: {
                                        url: '/cash/shopclient/json?name_bin=%QUERY&sort_by[name]=asc&limit=50&_fields[]=name&_fields[]=bin',
                                        wildcard: '%QUERY'
                                    }
                                });

                                field = $('#shop_client_name_product_volume.typeahead');
                                field.typeahead({
                                    hint: true,
                                    highlight: true,
                                    minLength: 1
                                }, {
                                    name: 'best-pictures',
                                    display: 'name',
                                    source: bestPictures,
                                    templates: {
                                        empty: [
                                            '<div class="empty-message">Клиент не найден</div>'
                                        ].join('\n'),
                                        suggestion: Handlebars.compile('<div>{{name}} – {{bin}}</div>')
                                    }
                                });
                                field.on('keypress', function(e) {
                                    if(e.which == 13) {
                                        $(this).parent().parent().find(".tt-suggestion:first-child").trigger('click');
                                    }
                                });
                                field.on('change', function() {
                                    client = $('#shop_client_id_product_volume');
                                    if(client.data('name') != $(this).val()){
                                        client.attr('value', '');
                                        client.val('');
                                        $(this).parent().addClass('has-error');
                                    }else{
                                        $(this).parent().removeClass('has-error');
                                    }
                                });
                                field.on('typeahead:select', function(e, selected) {
                                    $(this).parent().removeClass('has-error');

                                    var client = $('#shop_client_id_product_volume');
                                    client.data('name', selected.name);
                                    client.attr('value', selected.id);
                                    client.val(selected.id).trigger("change");
                                });
                            </script>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС08 Отгружено продукции по рубрикам ЖБИ и БС</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_products_rubric'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС09 Отгружено продукции по клиентам ЖБИ и БС</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_products_client'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_id_piece_products_client">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_id_piece_products_client" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС10 Реестр машин ЖБИ и БС</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_registry'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_id_piece_delivery">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_id_piece_delivery" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>ВС12 Реестр машин ответ.хранения</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/lessee_car_registry'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lessee_car_registry-shop_product_rubric_id">Рубрика</label>
                                    <select id="lessee_car_registry-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="-1" data-id="-1">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lessee_car_registry-shop_client_id">Клиент</label>
                                    <select id="lessee_car_registry-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                                        <option value="-1" data-id="-1">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/client/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php }else{ ?>
                <h3>МС01 Кассовая книга</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/payment_cashbox'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time1); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time2); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Лист</label>
                                    <input id="input-name" class="form-control" name="sheet_number" type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС02 Принято денег по клиентам</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/payments'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС03 Отгружено продукции по рубрикам</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products_rubric'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС04 Отгружено продукции по клиентам</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products_client'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_id_products_client">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_id_products_client" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="span-checkbox" style="margin-top: 32px;">
                                    <input name="is_charity" value="0" type="checkbox" class="minimal">
                                    Благотворительность
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС05 Реестр машин реализации продукции</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/car_registry'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_name_car_registry">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_name_car_registry" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС06 Реестр по доставке</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/delivery_transport'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_id_delivery_transport">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_id_delivery_transport" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС07 Перемещение по подразделениям</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_products_client'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС08 Отгружено продукции по рубрикам ЖБИ и БС</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_products_rubric'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС09 Отгружено продукции по клиентам ЖБИ и БС</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_products_client'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_id_piece_products_client">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_id_piece_products_client" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>МС10 Реестр машин ЖБИ и БС</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_registry'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период от</label>
                                    <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Период до</label>
                                    <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_product_rubric_id">Рубрика</label>
                                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shop_client_id_piece_delivery">Клиент</label>
                                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                            id="shop_client_id_piece_delivery" name="shop_client_id" class="form-control select2" style="width: 100%">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>ПР01 Заявка на день</h3>
                <div class="col-md-12">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopreport/plan_day_fixed'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date">Дата от</label>
                                    <input id="date" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo date('d.m.Y', strtotime('+1 day')); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date">Дата до</label>
                                    <input id="date" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y', strtotime('+1 day')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Отчет</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
	</div>
</div>
<script>
    function loadProducts(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/loadproduct'); ?>');
    }
    function loadClients(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/loadclient'); ?>');
    }
    function saveCars(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/savecars'); ?>');
    }
    function savePayments(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/savepayments'); ?>');
    }
    function saveСonsumables(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/saveconsumables'); ?>');
    }

    // выбираем новый файл
    $('input[type="file"]').change(function () {
        s = '';
        for(i = 0; i < this.files.length; i++){
            s = s + this.files[i].name + '; '
        }
        s = s.substr(0, s.length - 2);
        p = $(this).parent().attr('data-text', s);

    });
</script>