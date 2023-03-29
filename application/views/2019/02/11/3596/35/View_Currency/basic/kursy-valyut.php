<div class="currency">
	<label><i class="fa fa-fw fa-<?php
        switch ($data->id){
            case Model_Currency::USD:
                echo 'dollar';
                break;
            case Model_Currency::EUR:
                echo 'euro';
                break;
        }
        ?>"></i> <?php echo Func::mb_strtoupper($data->values['name']); ?> -</label> <span><?php echo round(1 / $data->values['currency_rate'], 2); ?></span>
</div>