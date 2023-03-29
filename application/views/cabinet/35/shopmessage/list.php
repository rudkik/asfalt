<div class="box <?php if($data->values['is_message_user']){echo 'box-success';}else{echo 'box-warning';}?> margin-b-0">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo htmlspecialchars($data->values['name']);?></h3>
        <h5 style="display: initial;"> [<?php echo $data->values['email'];?>] <span class="mailbox-read-time pull-right"><?php echo Helpers_DateTime::getDateTimeFormatRusMonthStr($data->values['created_at']);?></span></h5>
    </div>
    <div class="box-body no-padding">
        <div class="mailbox-read-message">

            <?php $values = Arr::path($data->values, 'options', array()); if((is_array($values)) && (count($values) > 0)){ ?>
            <div class="row">
                <div class="col-md-3">
                    <?php

                    $fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_message_catalog_id.options', array());
                    if(! is_array($fields)){
                        $fields = array();
                    }

                    $values = Arr::path($data->values, 'options', array());
                    if(! is_array($values)){
                        $values = array();
                    }

                    foreach ($fields as $field){
                        $value = Arr::path($values, $field['field'], '');
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <label>
                                    <?php echo $field['title']; ?>:
                                </label>
                                <span><?php echo $value; ?></span>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div class="col-md-9">
                    <?php echo $data->values['text'];?>
                </div>
            </div>
            <?php }else{?>
                <?php echo $data->values['text'];?>
            <?php }?>
        </div>
    </div>
    <?php if(count(Arr::path($data->values, 'files', array())) > 0){ ?>
        <div class="box-footer">
            <ul class="mailbox-attachments clearfix">
                <?php
                foreach(Arr::path($data->values, 'files', array()) as $index => $file) {
                    if($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE){
                ?>
                <li>
                    <span class="mailbox-attachment-icon has-img"><img src="<?php echo Helpers_Image::getPhotoPath($file['file'], 198, 132);?>" alt="<?php echo Arr::path($file, 'title', '');?>"></span>
                    <div class="mailbox-attachment-info" style="min-height: 57px;">
                        <a href="<?php echo $file['file'];?>" target="_blank" class="mailbox-attachment-name"><i class="fa fa-camera"></i> <?php echo Arr::path($file, 'file_name', '');?></a>
                        <span class="mailbox-attachment-size">
                            <?php echo Helpers_Image::getFileSizeStrRus(Arr::path($file, 'file_size', 0));?>
                            <a href="<?php echo $file['file'];?>" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                    </div>
                </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
    <?php } ?>
</div>