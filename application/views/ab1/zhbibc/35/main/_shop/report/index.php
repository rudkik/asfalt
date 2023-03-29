<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/zhbibc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>Отгружено объемов ЖБИ и БС</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products_volume'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
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
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>ЖБ01 Отгружено продукции по рубрикам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/product_rubric_department'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="product_rubric_department-created_at_from">Период от</label>
                                <input id="product_rubric_department-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="product_rubric_department-created_at_to">Период до</label>
                                <input id="product_rubric_department-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="product_rubric_department-shop_product_rubric_id">Рубрика</label>
                                <select id="product_rubric_department-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <b>Примечание:</b>
                                    <br>В отчете получаем данныех из Реализации и ЖБИ и БС в зависимости от подразделения оператора
                                </p>
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
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="piece_products_rubric-shop_product_rubric_id">Рубрика</label>
                                <select id="piece_products_rubric-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="piece_products_client-shop_product_rubric_id">Рубрика</label>
                                <select id="piece_products_client-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="is_subdivision" class="login-checkbox" checked value="1" id="realization_by_days-is_subdivision">
                                <label for="is_subdivision">Учитывать подразделения оператора</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <b>Примечание:</b>
                                    <br>Реализация зависит от подразделения оператора <b>при галочки "Учитывать подразделения оператора"</b>
                                </p>
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
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="piece_registry-shop_product_rubric_id">Рубрика</label>
                                <select id="piece_registry-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="is_subdivision" class="login-checkbox" checked value="1" id="realization_by_days-is_subdivision">
                                <label for="is_subdivision">Учитывать подразделения оператора</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <b>Примечание:</b>
                                    <br>Реализация зависит от подразделения оператора <b>при галочки "Учитывать подразделения оператора"</b>
                                </p>
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
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
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
            <h2 class="text-light-blue">Отчеты по материалам</h2>
            <h3>ВС06 Сводка по завозу и покупке материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_coming_group_daughter'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_material_rubric_id4">Рубрика</label>
                                <select id="shop_material_rubric_id4" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="shop_subdivision_receiver_id">Подразделение</label>
                                <select id="shop_subdivision_receiver_id" name="shop_subdivision_receiver_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/subdivision/receiver/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="is_quantity_receive" value="0" style="display: none;">
                                <input type="checkbox" name="is_quantity_receive" class="login-checkbox" id="is_quantity_receive">
                                <label for="is_quantity_receive">По количеству получателя</label>
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


            <h3>АБ01 Выпуск продукции по дням</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_by_days'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="realization_by_days-exit_at_from">Период от</label>
                                <input id="realization_by_days-exit_at_from" class="form-control" name="exit_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="realization_by_days-exit_at_to">Период до</label>
                                <input id="realization_by_days-exit_at_to" class="form-control" name="exit_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="realization_by_days-shop_product_rubric_id">Рубрика</label>
                                <select id="realization_by_days-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="is_holiday" class="login-checkbox" id="realization_by_days-is_holiday">
                                <label for="is_holiday">Только выходные/праздничные дни</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="is_night" class="login-checkbox" id="realization_by_days-is_night">
                                <label for="is_night">Ночные смены (с 22:00 до 06:00)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="is_subdivision" class="login-checkbox" checked value="1" id="realization_by_days-is_subdivision">
                                <label for="is_subdivision">Учитывать подразделения оператора</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <b>Примечание:</b>
                                    <br>Реализация зависит от подразделения оператора <b>при галочки "Учитывать подразделения оператора"</b>
                                </p>
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


            <h3>СБ08 Объем реализации</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/product_contract_client_price'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="product_contract_client_price-created_at_from">Период от</label>
                                <input id="product_contract_client_price-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="product_contract_client_price-created_at_to">Период до</label>
                                <input id="product_contract_client_price-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="product_contract_client_price-shop_client_id">Клиент</label>
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                                        id="product_contract_client_price-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="product_contract_client_price-shop_product_id">Продукция</label>
                                <select id="product_contract_client_price-shop_product_id" name="shop_product_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="shop_branch_id">
                            <div class="form-group">
                                <label for="product_contract_client_price-shop_branch_id">Филиал</label>
                                <select id="product_contract_client_price-shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <?php echo $siteData->replaceDatas['view::_shop/branch/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Рубрики</label>
                                <input hidden name="shop_product_rubric_id" value="84598,1081226">
                                <select id="shop_product_rubric_id" name="shop_product_rubric_id[]" class="form-control select2" multiple style="width: 100%;">
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
        </div>
	</div>
</div>
