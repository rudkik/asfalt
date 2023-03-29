<div id="panel<?php echo $data->values['id']; ?>" class="tab-pane fade in">
    <div class="box_text">
        <h4>Location: <?php echo Arr::path($data->values['options'], 'land', ''); ?></h4>
        <div class="objectText">
            <p><?php echo Arr::path($data->values['options'], 'position', ''); ?></p>
            <h4><span data-mce-mark="1">Requirements:</span></h4>
            <?php echo Arr::path($data->values['options'], 'demand', ''); ?>
            <h4>Job description:</h4>
            <?php echo Arr::path($data->values['options'], 'info', ''); ?>
            <h4>Conditions:</h4>
            <?php echo Arr::path($data->values['options'], 'conditions', ''); ?>
        </div>
    </div>
</div>