<?php $isFinish = strtotime($data->values['to_at']) < strtotime(date('Y-m-d')); ?>
<li <?php if($isFinish){echo 'class="attorney-finish"';} ?>>
    <a href="#" data-id="<?php echo $data->id; ?>" data-amount="<?php echo $data->values['balance']; ?>">
        <div <?php if($isFinish){echo 'class="attorney-finish"';} ?>>
            <?php echo $data->values['name']; ?><br>
            <span class="text-red"> Остаток: <b style="font-size: 18px;"><?php echo Func::getPriceStr($siteData->currency, $data->values['balance']); ?></b></span>
        </div>
    </a>
</li>