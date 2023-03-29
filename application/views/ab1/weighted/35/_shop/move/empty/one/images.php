<div id="dialog-images" class="modal">
    <div class="modal-dialog" style="max-width: 1000px; width: 100%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Фотографии машины №<b><?php echo $data->values['name']; ?></b></h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div id="emptyousel" class="emptyousel slide" data-ride="emptyousel">
                        <div class="emptyousel-inner">
                            <?php
                            $i = 1;
                            foreach(Arr::path($data->values, 'files', array()) as $index => $file) {
                                if((! is_array($file)) || (!key_exists('type', $file))){
                                    continue;
                                }
                                $tуpe = intval(Arr::path($file, 'type', 0));
                                if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
                                    ?>
                                    <div class="item<?php if ($i == 1){$i++; echo ' active';}?>">
                                        <h2 style="margin: 0px 0px 5px"><?php echo Arr::path($file, 'title', '');?></h2>
                                        <img src="<?php echo Helpers_Image::getPhotoPath($file['file'], 1000, 562);?>" alt="<?php echo Arr::path($file, 'title', '');?>">
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <a class="left emptyousel-control" href="#emptyousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Предыдущий</span>
                        </a>
                        <a class="right emptyousel-control" href="#emptyousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Следующий</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>