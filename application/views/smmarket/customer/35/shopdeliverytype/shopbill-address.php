<div class="row">
    <div class="col-md-6">
        <div class="row">
            <?php foreach($data->values['receiver_options'] as $value){ ?>
                <div class="col-md-12" style="margin-bottom: 5px;">
                    <label style="margin-bottom: 0px;"><?php echo $value['title']; ?></label>
                    <input type="text" class="form-control pull-right" name="receiver_data[<?php echo $value['field']; ?>]" value="<?php echo Arr::path($data->additionDatas, 'receiver_data.'.$value['field'], ''); ?>"/>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <?php foreach($data->values['sender_options'] as $value){ ?>
                <div class="col-md-12">
                    <label style="margin-bottom: 0px;"><?php echo $value['title']; ?></label>
                    <input type="text" class="form-control pull-right" name="sender_data[<?php echo $value['field']; ?>]" value="<?php echo Arr::path($data->additionDatas, 'receiver_data.'.$value['field'], ''); ?>"/>
                </div>
            <?php } ?>
        </div>
    </div>
</div>