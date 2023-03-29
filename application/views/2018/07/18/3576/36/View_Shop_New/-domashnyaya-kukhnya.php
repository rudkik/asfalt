<div class="col-sm-6">
    <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 675, 432); ?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
</div>
<div class="col-sm-6">
    <div class="line">
        <p>Our home-like café serves Kazakh and Uighur and European cuisine: beshbarmak, lagman, plov, manty, pelmeni.</p>
    </div>
    <div class="line">
        <p><b>Orders are placed in advance:<br> <a href="tel:+7 702 431 21 35">+7 702 431 21 35</a> <br> <a href="tel:+7 707 910 80 79">+7 707 910 80 79</a></b></p>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <b>Opening hours:</b>
        </div>
    </div>
    <div class="row menu">
        <div class="col-sm-12" style="margin-bottom: 15px">
            <div class="row">
                <div class="col-sm-6 bold">
                    Breakfast:
                </div>
                <div class="col-sm-6">
                    08.30 - 10.30
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 bold">
                    Lunch:
                </div>
                <div class="col-sm-6">
                    12.00 - 15.00
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 bold">
                    Dinner:
                </div>
                <div class="col-sm-6">
                    18.00 - 21.00
                </div>
            </div>
        </div>
    </div>
    <div class="line">
        <p><b>Barbeque</b></p>
        <p>We offer barbeque equipment free of charge. There are tables and washing basin in the Barbeque Corner.</p>
    </div>
    <div class="row">
        <div class="box-btn">
            <a href="<?php echo Arr::path($data->values['options'], 'price_list.file', '') ?>" class="btn btn-flat btn-blue">Download Menu</a>
        </div>
    </div>
</div>