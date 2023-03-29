<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/cashbox/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>КА01 Отчет по поступлению денежных средств по фискальному регистратору</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/payment_cashbox_days'); ?>" method="post" enctype="multipart/form-data" >
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
                                <label for="payment_cashbox_days-shop_cashbox_id">Фискальный регистратор</label>
                                <select id="payment_cashbox_days-shop_cashbox_id" name="shop_cashbox_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/cashbox/list/list']; ?>
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
            <h3>МС01 Кассовая книга</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/payment_cashbox'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="payment_cashbox-created_at_from">Период от</label>
                                <input id="payment_cashbox-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time1); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="payment_cashbox-created_at_to">Период до</label>
                                <input id="payment_cashbox-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($time2); ?>">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="payment_cashbox-sheet_number">Лист</label>
                                <input id="payment_cashbox-sheet_number" class="form-control" name="sheet_number" type="text" value="1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payment_cashbox-shop_cashbox_id">Фискальный регистратор</label>
                                <select id="payment_cashbox-shop_cashbox_id" name="shop_cashbox_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/cashbox/list/list']; ?>
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

            <h2 class="text-light-blue">Отчеты по магазину</h2>
            <h3>Развернутый отчет по реализации по чекам</h3>
            <div class="col-md-12">
                <form action="<?php echo '/cashbox/shopreport/tax_checks'; ?>" method="post" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tax_checks-created_at_from">Период от</label>
                                <input id="tax_checks-created_at_from" class="form-control" name="created_at_from" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tax_checks-created_at_to">Период до</label>
                                <input id="tax_checks-created_at_to" class="form-control" name="created_at_to" type="datetime" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tax_checks-shop_branch_id">Филиал</label>
                                <select id="tax_checks-shop_branch_id" name="_shop_branch_id" class="form-control select2" style="width: 100%;">
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