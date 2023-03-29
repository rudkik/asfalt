<div id="panel<?php echo $data->values['id']; ?>" class="tab-pane fade in">
    <div class="box_text">
        <h4>Lokalizacja: <?php echo Arr::path($data->values['options'], 'land', ''); ?></h4>
        <div class="objectText">
            <p><?php echo Arr::path($data->values['options'], 'position', ''); ?></p>
            <h4><span data-mce-mark="1">Wymagania:</span></h4>
            <?php echo Arr::path($data->values['options'], 'demand', ''); ?>
            <h4>Opis pracy:</h4>
            <?php echo Arr::path($data->values['options'], 'info', ''); ?>
            <h4>Warunki:</h4>
            <?php echo Arr::path($data->values['options'], 'conditions', ''); ?>
        </div>
    </div>
</div>