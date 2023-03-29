<div class="item">
    <div class="slider" style="background-image: url('<?php echo $data->values['image_path']; ?>'); background-size: auto 100%; height: 497px;">
        <?php if(Func::_empty(Arr::path($data->values['options'], 'button', ''))){ ?>
            <a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>">
            <div class="container">
                <h2><?php echo $data->values['name']; ?></h2>
                <div class="text"><?php echo $data->values['text']; ?></div>
            </div>
            </a>
        <?php }else{ ?>
            <div class="container">
                <div class="box-info-atomy">
                    <h2><?php echo $data->values['name']; ?></h2>
                    <div class="text"><?php echo $data->values['text']; ?></div>
                    <?php if(!Func::_empty(Arr::path($data->values['options'], 'url', ''))){ ?>
                        <a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>" class="btn btn-flat btn-purple"><?php echo Arr::path($data->values['options'], 'button', ''); ?></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>