<div class="box-slider">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="box-data">
                    <h1><?php echo $data->values['name']; ?></h1>
                    <h2><?php echo Arr::path($data->values['options'], 'h2', ''); ?></h2>
                    <div class="line"></div>
                    <p class="info"><?php echo $data->values['text']; ?></p>
                    <button type="button" class="btn btn-default btn-red">заказать</button>
                </div>
            </div>
            <div class="col-md-5">
                <img class="img-slider" src="<?php echo $data->values['image_path']; ?>">
            </div>
        </div>
    </div>
</div>
