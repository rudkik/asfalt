<?php
$time1 = date('d.m.Y',strtotime('-1 day')).' 06:00';
$time2 = date('d.m.Y').' 06:00';
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
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <div class="col-md-12">
                    <h3>Загрузка</h3>
                    <form action="<?php echo Func::getFullURL($siteData, '/shopxml/loadproduct'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    Файл
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="file-upload" data-text="Выберите файл">
                                    <input type="file" name="file[]" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title"></div>
                            <div class="col-md-9">
                                <label class="span-checkbox">
                                    <input name="is_clear_block_amount" value="0" type="checkbox" class="minimal">
                                    Закрытие смены
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary" onclick="loadDeliveries()">Загрузить доставку</button>
                                <button type="submit" class="btn btn-primary" onclick="loadProducts()">Загрузить товары</button>
                                <button type="submit" class="btn btn-primary" onclick="loadClients()">Загрузить клиентов</button>
                                <button type="submit" class="btn btn-primary" onclick="loadMoveClients()">Загрузить подразделения</button>
                                <button type="submit" class="btn btn-primary" onclick="loadActRevises()">Загрузить акт сверки</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <h3 style="margin-top: 30px;">Загрузка файл из АСУ</h3>
                    <form action="<?php echo Func::getFullURL($siteData, '/shopxml/load_asu'); ?>" method="post" enctype="multipart/form-data" >
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    Файл
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="file-upload" data-text="Выберите файл">
                                    <input type="file" name="file[]" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                    Место производства
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" required style="width: 100%;">
                                    <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-primary">Загрузить</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
            <div class="col-md-12">
                <h3 style="margin-top: 30px;">Выгрузка</h3>
                <form action="<?php echo Func::getFullURL($siteData, '/shopxml/loadproduct'); ?>" method="get" >
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
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary" onclick="saveAll()">Выгрузить все</button>
                            <button type="submit" class="btn btn-primary" onclick="saveMoveCars()">Выгрузить перемещение</button>
                            <button type="submit" class="btn btn-primary" onclick="savePayments()">Выгрузить счета</button>
                            <button type="submit" class="btn btn-primary" onclick="savePaymentReturns()">Выгрузить возврат</button>
                            <button type="submit" class="btn btn-primary" onclick="saveСonsumables()">Выгрузить расходники</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
<script>
    function loadActRevises(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/load_act_revise'); ?>');
    }
    function loadDeliveries(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/loaddelivery'); ?>');
    }
    function loadProducts(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/loadproduct'); ?>');
    }
    function loadClients(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/loadclient'); ?>');
    }
    function loadMoveClients(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/loadmoveclient'); ?>');
    }
    function saveCars(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/savecars'); ?>');
    }
    function saveMoveCars(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/savemovecars'); ?>');
    }
    function savePayments(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/savepayments'); ?>');
    }
    function savePaymentReturns(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_payment_returns'); ?>');
    }
    function saveСonsumables(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/saveconsumables'); ?>');
    }
    function saveAll(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/saveall'); ?>');
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