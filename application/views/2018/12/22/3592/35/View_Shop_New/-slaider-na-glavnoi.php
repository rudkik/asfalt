<div class="item">
    <div class="box-slider" style="background-image: url('<?php echo $data->values['image_path']; ?>'); background-size: cover; background-position: center center;">
        <div class="container">
            <div class="box-data">
                <h2><?php echo $data->values['name']; ?></h2>
                <?php if($data->values['text']){ ?>
                    <div class="line"></div>
                    <div class="info"><?php echo $data->values['text']; ?></div>
                <?php } ?>
                <a class="btn btn-default btn-yellow" href="#modal-send" data-toggle="modal">Записаться на прием</a>
            </div>
        </div>
    </div>
</div>