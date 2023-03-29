<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
$date = date('d.m.Y');
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/pto/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>ПТ01 ПЛАТЕЖНЫЙ КАЛЕНДАРЬ по исполнению условий договора</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/payment_schedule'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="payment_schedule-date">На дату</label>
                                <input id="payment_schedule-date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="span-checkbox" style="margin-top: 32px;">
                                <input name="is_contract" value="1" checked type="checkbox" class="minimal">
                                Только клиенты с действующими договорами на заданную дату
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
            <h3>СБ01 Реестр банковских документов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/act_revise_registry_payment'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="act_revise_registry_payment-date_from">Период от</label>
                                <input id="act_revise_registry_payment-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="act_revise_registry_payment-date_to">Период до</label>
                                <input id="act_revise_registry_payment-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
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
            <h3>СБ02 Дебиторы и кредиторы</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/client_debtor_creditor'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="client_debtor_creditor-date">Дата</label>
                                <input id="client_debtor_creditor-date" class="form-control" name="date" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="client_debtor_creditor-shop_client_id">Клиент</label>
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                                        id="client_debtor_creditor-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="span-checkbox" style="margin-top: 32px;">
                                <input name="is_contract" value="1" checked type="checkbox" class="minimal">
                                Только клиенты с действующими договорами на заданную дату
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    <b>Примечание:</b>
                                    <br>в отчет попадают клиенты, у которых стоит галочка покупатель в справочнике <a href="<?php echo Func::getFullURL($siteData, '/shopclient/index'); ?>">Клиенты</a>
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
            <h3>СБ03 Отчет по отгруженным ценам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/product_client_price'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="product_client_price-created_at_from">Период от</label>
                                <input id="product_client_price-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="product_client_price-created_at_to">Период до</label>
                                <input id="product_client_price-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="product_client_price-shop_client_id">Клиент</label>
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                                        id="product_client_price-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_product_rubric_id1">Рубрика</label>
                                <select id="shop_product_rubric_id1" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="product_client_price-shop_product_id">Продукция</label>
                                <select id="product_client_price-shop_product_id" name="shop_product_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="product_client_price-shop_branch_id">Филиал</label>
                                <select id="product_client_price-shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <?php echo $siteData->replaceDatas['view::_shop/branch/list/list']; ?>
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
            <h3>СБ05 Отчет по отгрузке в разрезе договоров клиентов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/contract_client_goods'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="contract_client_goods-date_from">Период от</label>
                                <input id="contract_client_goods-date_from" class="form-control" name="date_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="contract_client_goods-date_to">Период до</label>
                                <input id="contract_client_goods-date_to" class="form-control" name="date_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contract_client_goods-shop_client_id">Клиент</label>
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                                        id="contract_client_goods-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
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
            <h3>СБ07 Отчет по товарам клиента</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/product_client_one'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="product_client_one-created_at_from">Период от</label>
                                <input id="product_client_one-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="product_client_one-created_at_to">Период до</label>
                                <input id="product_client_one-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="product_client_one-shop_client_id">Клиент</label>
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                                        id="product_client_one-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="span-checkbox" style="margin-top: 32px;">
                                <input name="is_delivery" value="0" type="checkbox" class="minimal">
                                Включить доставку
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="product_contract_client_price-shop_branch_id">Филиал</label>
                                <select id="product_contract_client_price-shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <?php echo $siteData->replaceDatas['view::_shop/branch/list/list']; ?>
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

            <h2 class="text-light-blue">Отчеты по заявкам</h2>
            <h3>ПР01 Заявка на день</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/plan_day_fixed'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>ПР02 Анализ реализации продукции</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/plan_analysis_fixed'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата от</label>
                                <input id="date" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo date('d.m.Y', strtotime('-1 day')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата до</label>
                                <input id="date" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y', strtotime('-1 day')); ?>">
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

            <h2 class="text-light-blue">Отчеты по договорам</h2>
            <h3>ПР06 Реестр договоров по потребителям продукции</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/contract_product'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="contract_product-contract_date_year">Период от</label>
                                <input id="contract_product-contract_date_year" class="form-control" name="contract_date_year" type="phone" value="<?php echo date('Y'); ?>">
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
            <h3>ПР07 Справка по исполнению договоров потребителям продукции</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/contract_spent'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="contract_spent-date_from">Период от</label>
                                <input id="contract_spent-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getYearBeginStr(date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="contract_spent-date_to">Период до</label>
                                <input id="contract_spent-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time2); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contract_spent-shop_product_rubric_id">Рубрика</label>
                                <select id="contract_spent-shop_product_rubric_id" name="shop_product_rubric_ids[]" class="form-control select2" multiple required style="width: 100%;">
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
            <h3>ПР08 Справка по исполнению договоров потребителям продукции (с доп.соглашениями)</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/contract_spent_bank'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="contract_spent_bank-date_from">Период от</label>
                                <input id="contract_spent_bank-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getYearBeginStr(date('Y'))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="contract_spent_bank-date_to">Период до</label>
                                <input id="contract_spent_bank-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time2); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contract_spent_bank-shop_product_rubric_id">Рубрика</label>
                                <select id="contract_spent_bank-shop_product_rubric_id" name="shop_product_rubric_ids[]" class="form-control select2" multiple required style="width: 100%;">
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

            <h2 class="text-light-blue">Отчеты по продукции</h2>
            <h3>МС02 Принято денег по клиентам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/payments'); ?>" method="get" enctype="multipart/form-data" >
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
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products_rubric'); ?>" method="get" enctype="multipart/form-data" >
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
                                <label for="shop_branch_id">Филиал</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
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
            <h3>МС04 Отгружено продукции по клиентам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products_client'); ?>" method="get" enctype="multipart/form-data" >
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
                                <label for="products_client-shop_client_id">Клиент</label>
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                                        id="products_client-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
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
            <h3>МС06 Реестр по доставке</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/delivery_transport'); ?>" method="get" enctype="multipart/form-data" >
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
                                <label for="delivery_transport-shop_product_rubric_id">Рубрика</label>
                                <select id="delivery_transport-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="delivery_transport-shop_client_id">Клиент</label>
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                                        id="delivery_transport-shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
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
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_products_client'); ?>" method="get" enctype="multipart/form-data" >
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
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_products_rubric'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>МС10 Реестр машин ЖБИ и БС</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/piece_registry'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>ВС01 Сводка по реализации</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_turn_type'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exit_at_from">Период от</label>
                                <input id="exit_at_from" class="form-control" name="exit_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exit_at_to">Период до</label>
                                <input id="exit_at_to" class="form-control" name="exit_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="realization_turn_type-shop_product_rubric_id">Рубрика</label>
                                <select id="realization_turn_type-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
            <h3>ВС02 Сводка по выпуску (АСУ/Место погрузки)</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_asu'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="realization_asu-shop_product_rubric_id">Рубрика</label>
                                <select id="realization_asu-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
            <h3>ВС18 Сводка по выпуску (АСУ/Место погрузки) по всем филиалам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_asu_branch'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="realization_asu-shop_product_rubric_id">Рубрика</label>
                                <select id="realization_asu-shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
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
            <h3>ВС03 Сводка по перемещению продукции</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_products'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>ВС04 Отчет по благотворительности</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products_client'); ?>" method="get" enctype="multipart/form-data" >
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
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_charity" value="1" type="text" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>ВС05 Отчет по выпуску пустых машин</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/car_empty'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>АБ01 Выпуск продукции по дням</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/realization_by_days'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exit_at_from">Период от</label>
                                <input id="exit_at_from" class="form-control" name="exit_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exit_at_to">Период до</label>
                                <input id="exit_at_to" class="form-control" name="exit_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_turn_place_id">АСУ</label>
                                <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="is_holiday" class="login-checkbox" id="is_holiday">
                                <label for="is_holiday">Только выходные/праздничные дни</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="is_night" class="login-checkbox" id="is_night">
                                <label for="is_night">Ночные смены (с 22:00 до 06:00)</label>
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
            <h3>АБ02 Отгружено продукции по машинам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/products'); ?>" method="get" enctype="multipart/form-data" >
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

            <h2 class="text-light-blue">Отчеты по материалам</h2>
            <h3>ВС06 Сводка по завозу и покупке материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_coming_group_daughter'); ?>" method="get" enctype="multipart/form-data" >
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
                                <label for="shop_material_rubric_id5">Рубрика</label>
                                <select id="shop_material_rubric_id5" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_branch_id">Филиал</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
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
            <h3>ВС07 Отчет по вывозу материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_export_group_daughter'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>ВС08 Отчет по завозу материалов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_daughter'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>ВС09 Сводка по завозу материалов по сменам</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_coming'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="material_coming-date">Дата</label>
                                <input id="material_coming-date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo $date; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="material_coming-shop_material_rubric_id">Рубрика</label>
                                <select id="material_coming-shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" name="is_update_tare_at" class="login-checkbox" id="is_update_tare_at">
                                <label for="is_update_tare_at">Поиск по дате повторного взвешивания</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>ВС10 Список машин с материалом</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_list_car'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="material_list_car-shop_material_rubric_id">Рубрика</label>
                                <select id="material_list_car-shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="material_list_car-shop_material_id">Транспортная компания</label>
                                <select id="material_list_car-shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="checkbox" name="is_import" class="login-checkbox" id="is_import">
                                <label for="is_import">Завоз и </label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="checkbox" name="is_export" class="login-checkbox" id="is_export">
                                <label for="is_export">Вывоз</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="checkbox" name="is_buy" class="login-checkbox" id="is_buy">
                                <label for="is_buy">Покупка</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>ВС11 Список машин с материалом версия 2</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_list_car_v2'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_branch_id">Получатель</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_material_id2">Материал</label>
                                <select id="shop_material_id2" name="shop_material_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="shop_material_id">Транспортная компания</label>
                                <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>ВС12 Реестр машин ответ.хранения</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/lessee_car_registry'); ?>" method="get" enctype="multipart/form-data" >
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
            <h3>ВС13 Прочие машины</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_other_list'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="move_other_list_shop_material_id">Материал</label>
                                <select id="move_other_list_shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="move_other_list_shop_material_id">Материал</label>
                                <select id="move_other_list_shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
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
            <h3>ВС17 Пустые машины</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/move_empty_list'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
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
            <h3>АБ03 Автоуслуги завоза материала по дням</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_days'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="material_days-shop_material_rubric_id">Рубрика</label>
                                <select id="material_days-shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="material_days-shop_subdivision_receiver_id">Подразделение</label>
                                <select id="material_days-shop_subdivision_receiver_id" name="shop_subdivision_receiver_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/subdivision/receiver/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="checkbox" name="is_import" class="login-checkbox" id="is_import">
                                <label for="is_import">Завоз</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="checkbox" name="is_export" class="login-checkbox" id="is_export">
                                <label for="is_export">Вывоз</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>АБ04 Реестр заезда и взвешивания тары материала</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_entry_and_tare_cars'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="material_entry_and_tare_cars-shop_material_rubric_id">Рубрика</label>
                                <select id="material_entry_and_tare_cars-shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>

            <h2 class="text-light-blue">Отчеты по балласту</h2>
            <h3>БТ01 Сводка балласта за смену</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_day'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="shop_work_shift_id">Смена</label>
                                <select id="shop_work_shift_id" name="shop_work_shift_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/work/shift/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_branch_id">Филиал</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
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
            <h3>БТ02 Учет рейсов балласта по дням</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_day_drivers'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_from">Период от</label>
                                <input id="created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="shop_ballast_car_id">№ машины</label>
                                <select id="shop_ballast_car_id" name="shop_ballast_car_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/ballast/car/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="shop_ballast_driver_id">Водитель</label>
                                <select id="shop_ballast_driver_id" name="shop_ballast_driver_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/ballast/driver/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_branch_id">Филиал</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
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
            <h3>НУ01 Сводка по балласту выпуск материала</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_raw_material'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_from">Период от</label>
                                <input id="ballast_raw_material-date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="ballast_raw_material-date_to">Период до</label>
                                <input id="ballast_raw_material-date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_branch_id">Филиал</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <input name="is_waybill" value="1" style="display: none">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>НБ01 Уведомление о приеме и сдачи цистерн</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/boxcar_drain'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="boxcar_drain-date_from">Дата убытия вагона от</label>
                                <input id="boxcar_drain-date_from" class="form-control" name="date_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="boxcar_drain-date_to">Дата убытия вагона до</label>
                                <input id="boxcar_drain-date_to" class="form-control" name="date_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_boxcar_client_id">Поставщик</label>
                                <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите поставщика</option>
                                    <?php echo $siteData->globalDatas['view::_shop/boxcar/client/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_raw_id">Сырье</label>
                                <select id="shop_raw_id" name="shop_raw_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите сырье</option>
                                    <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
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

            <h2 class="text-light-blue">Отчеты по вагонам</h2>
            <h3>ВГ02 Вагоны в пути</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/boxcar_in_way'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_boxcar_client_id">Поставщик</label>
                                <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите поставщика</option>
                                    <?php echo $siteData->globalDatas['view::_shop/boxcar/client/list/list']; ?>
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
            <h3>ВГ03 Прибывшие вагоны</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/boxcar_arrival'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_departure_from">Прибытие от</label>
                                <input id="date_departure_from" class="form-control" name="date_arrival_from" type="datetime" date-type="datetime">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_to">Прибытие до</label>
                                <input id="date_departure_to" class="form-control" name="date_arrival_to" type="datetime" date-type="datetime">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="span-checkbox" style="margin-top: 32px;">
                                    <input name="is_date_departure_empty" data-id="1" value="1" type="checkbox" class="minimal" checked>
                                    Неубывшие
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_boxcar_client_id">Поставщик</label>
                                <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите поставщика</option>
                                    <?php echo $siteData->globalDatas['view::_shop/boxcar/client/list/list']; ?>
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
            <h3>ВГ04 Разгружающиеся вагоны</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/boxcar_unload'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_boxcar_client_id">Поставщик</label>
                                <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите поставщика</option>
                                    <?php echo $siteData->globalDatas['view::_shop/boxcar/client/list/list']; ?>
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
            <h3>ВГ06 Время простоя вагонов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/boxcar_downtime'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_departure_from">Убытие от</label>
                                <input id="date_departure_from" class="form-control" name="date_departure_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_to">Убытие до</label>
                                <input id="date_departure_to" class="form-control" name="date_departure_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_boxcar_client_id">Поставщик</label>
                                <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите поставщика</option>
                                    <?php echo $siteData->globalDatas['view::_shop/boxcar/client/list/list']; ?>
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
            
            <h3>ВГ09 Общий реестр по выгрузке мин. порошка</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/mineral_powder_car_list'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_departure_from">Время взвешивания от</label>
                                <input id="date_departure_from" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="created_at_to">Время взвешивания до</label>
                                <input id="date_departure_to" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
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

            <h2 class="text-light-blue">Отчеты по транспорту</h2>
            <h3>АТ01 Анализ работы грузоперевозок транспортных средств МАТЕРИАЛА</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_analysis'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_material_rubric_id">Рубрика</label>
                                <select id="shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date">Транспорная компания</label>
                                <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_branch_id">Филиал</label>
                                <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    Расчет:
                                    <br>если стоит галочка <b>По количеству получателя</b>, то суммируется вес по приезду машины
                                    <br>иначе, суммируется вес по накладной, если есть или вес отправителя
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
            <h3>АТ02 Анализ работы грузоперевозок транспортных средств МАТЕРИАЛА за период</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/material_analysis_10'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата от</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus(Helpers_DateTime::minusDays(date('d.m.Y'), 10)); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_material_rubric_id">Рубрика</label>
                                <select id="shop_material_rubric_id" name="shop_material_rubric_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/material/rubric/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date">Транспорная компания</label>
                                <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <input name="is_quantity_receive" value="0" style="display: none;">
                                <input type="checkbox" name="is_quantity_receive" class="login-checkbox" id="is_quantity_receive">
                                <label for="is_quantity_receive">По количеству получателя</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input name="is_vertical" value="0" style="display: none;">
                                <input type="checkbox" name="is_vertical" class="login-checkbox" id="is_vertical" value="1" checked>
                                <label for="is_vertical">Вертикальный</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>
                                    Расчет:
                                    <br>если стоит галочка <b>По количеству получателя</b>, то суммируется вес по приезду машины
                                    <br>иначе, суммируется вес по накладной, если есть или вес отправителя
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
            <h3>АТ03 Анализ работы грузоперевозок транспортных средств ПРОДУКЦИИ</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/product_analysis'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
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
            <h3>АТ04 Анализ работы грузоперевозок транспортных средств БАЛЛАСТА</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/ballast_analysis'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
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