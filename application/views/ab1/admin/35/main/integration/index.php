<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/admin/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h2 class="text-light-blue">Синхронизация</h2>
            <h3>Клиенты</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Client'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Договора клиентов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="from_at_from_equally">Период от</label>
                                <input id="from_at_from_equally" class="form-control" name="from_at_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="from_at_to">Период до</label>
                                <input id="from_at_to" class="form-control" name="from_at_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Client_Contract'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Оплата Асфальтобетон</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_from_equally">Период от</label>
                                <input id="created_at_from_equally" class="form-control" name="created_at_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Payment'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Возвраты Асфальтобетон</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_from_equally">Период от</label>
                                <input id="created_at_from_equally" class="form-control" name="created_at_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Payment_Return'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Расходники Асфальтобетон</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
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
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Consumable'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Накладные Асфальтобетон</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from_equally">Период от</label>
                                <input id="date_from_equally" class="form-control" name="date_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Invoice'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Акты выполненных работ Асфальтобетон</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from_equally">Период от</label>
                                <input id="date_from_equally" class="form-control" name="date_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Act_Service'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Путевые листы Асфальтобетон</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from_equally">Период от</label>
                                <input id="date_from_equally" class="form-control" name="date_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Ab1_Shop_Transport_Waybill'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Бригадный наряд Асфальтобетон</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/work_1с'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from">Период от</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>

            <h3>Продукция Магазина</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Magazine_Shop_Product'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Возврат товара клиенту Магазин</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from_equally">Период от</label>
                                <input id="date_from_equally" class="form-control" name="date_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Magazine_Shop_Realization_Return'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Приход товара Магазин</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from_equally">Период от</label>
                                <input id="date_from_equally" class="form-control" name="date_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Magazine_Shop_Receive'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Возврат поставщику товара Магазин</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from_equally">Период от</label>
                                <input id="date_from_equally" class="form-control" name="date_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Magazine_Shop_Return'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Перемещение товара Магазин</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_from_equally">Период от</label>
                                <input id="created_at_from_equally" class="form-control" name="created_at_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="created_at_to">Период до</label>
                                <input id="created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Magazine_Shop_Move'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3>Накладные Магазин</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/sync'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from_equally">Период от</label>
                                <input id="date_from_equally" class="form-control" name="date_from_equally" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input id="id" class="form-control" name="id" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="limit">Кол-во записей</label>
                                <input id="limit" class="form-control" name="limit" type="text" value="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input name="object" value="<?php echo 'Magazine_Shop_Invoice'; ?>" style="display: none">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>

            <h3>Удержание по Магазину</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/realization_workers'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from">Период от</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>

            <h3>Талоны по Магазину</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/integration/talons'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-1-5">
                            <div class="form-group">
                                <label for="date_from">Месяц</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Синхронизировать</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>