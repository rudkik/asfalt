<?php
$fiscalResult = Request_RequestParams::getParam('fiscal_result');
$errorCode = Arr::path($fiscalResult, 'error_code', -999);
if($fiscalResult !== null
    && (Arr::path($fiscalResult, 'is_send_local', 0) != 1 || $errorCode == -999 || $errorCode > 0)
    && Arr::path($fiscalResult, 'status', 0) != 1){ ?>
    <div class="callout callout-danger">
        <h4>Ошибка фискального регистратора</h4>
        <?php if(!is_array($fiscalResult)){  ?>
            <p>Фатальная ошибка, обратитесь к разработчику.</p>
        <?php }elseif(Arr::path($fiscalResult, 'is_send_local', 0) != 1){  ?>
            <p>Не удалось подключиться к удаленному компьютеру "<?php echo Arr::path($siteData->shop->getOptionsArray(), 'cash_machine_ip', 'localhost'); ?>"</p>
        <?php }elseif($errorCode == -999 && Func::_empty(Arr::path($fiscalResult, 'number', ''))){  ?>
            <p>Фискальный регистратор находится в тестовом режиме.</p>
        <?php }else{ ?>
            <p><?php echo Drivers_CashRegister_Exception::getErrorStrRus($errorCode); ?></p>
        <?php } ?>
    </div>
<?php } ?>