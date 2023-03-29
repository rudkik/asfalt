<div class="col-sm-6">
    <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 675, 432); ?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
</div>
<div class="col-sm-6">
    <div class="line">
        <p>Наши повара готовят блюда восточной и европейской кухни по-домашнему, с душой. В меню вы найдете каши, супы, вторые блюда, салаты, напитки.  Вы можете заказать лагман, плов, манты, сырне, бешбармак, куырдак, пельмени и многое другое.</p>
    </div>
    <div class="line">
        <p><b>Заказы принимаются заранее по телефонам:<br> <a href="tel:+7 702 431 21 35">+7 702 431 21 35</a> <br> <a href="tel:+7 707 910 80 79">+7 707 910 80 79</a></b></p>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <b>Время работы домашней кухни:</b>
        </div>
    </div>
    <div class="row menu">
        <div class="col-sm-12" style="margin-bottom: 15px">
            <div class="row">
                <div class="col-sm-6 bold">
                    Завтрак:
                </div>
                <div class="col-sm-6">
                    8.30 - 10.30
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 bold">
                    Обед:
                </div>
                <div class="col-sm-6">
                    12.00 - 15.00
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 bold">
                    Ужин:
                </div>
                <div class="col-sm-6">
                    18.00 - 21.00
                </div>
            </div>
        </div>
    </div>
    <div class="line">
        <p><b>Мангал зона</b></p>
        <p>Для любителей шашлыка и коктала, у нас есть мангал зона с мангалами, печкой-казаном и коктальницей. Для удобства гостей в мангал зоне есть столы и рукомойник. Вы можете самостоятельно приготовить шашлык или коктал, или другое блюдо в казане совершенно бесплатно.</p>
    </div>
    <div class="row">
        <div class="box-btn">
            <a href="<?php echo Arr::path($data->values['options'], 'price_list.file', '') ?>" class="btn btn-flat btn-blue">Скачать меню</a>
        </div>
    </div>
</div>