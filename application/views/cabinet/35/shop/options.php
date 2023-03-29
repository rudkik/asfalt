<section class="content top20" id="nastoika-magazina" id="edit_panel" style="padding-top: 0px;">
    <div class="row top20 ">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Базовый язык</label>
            <div class="col-sm-4">
                <?php echo trim($data->additionDatas['view::languages/list/list']); ?>
            </div>
        </div>
    </div>
    <div class="row top10">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Базовая валюта</label>
            <div class="col-sm-4">
                <?php echo trim($data->additionDatas['view::currencies/list/list']); ?>
            </div>
        </div>
    </div>
    <div class="row top10">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Название поддомена</label>
            <div class="col-sm-4">
                <input type="text" name="sub_domain" class="form-control" value="<?php echo $data->values['sub_domain']; ?>"  placeholder="Ваш поддомен">
            </div>
        </div>
    </div>
    <div class="row top10">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Купленное имя сайта</label>
            <div class="col-sm-4">
                <input type="text" name="domain" class="form-control" value="<?php echo $data->values['domain']; ?>" placeholder="Имя сайта">
            </div>
        </div>
    </div>
    <div class="row top20">
        <!-- block -->
        <div class="col-md-6">
            <h3>На каких языка отображается сайт</h3>

            <?php echo trim($data->additionDatas['view::languages/shopoptions']); ?>

            <!-- block -->
            <div class="row">
                <div class="col-md-8 ptop5">
                    <a href="#">Добавить язык</a>
                </div>
            </div><!--// block -->
        </div>

        <div class="col-md-6">
            <h3>В какие валюты пересчитывать цены</h3>

            <?php echo trim($data->additionDatas['view::currencies/shopoptions']); ?>

            <!-- block -->
            <div class="row">
                <div class="col-md-8 ptop5">
                    <a href="#">добавить валюту</a>
                </div>
            </div><!--// block -->
        </div>
    </div>
    <div class="row top20">
        <div class="col-md-2">
            <input type="submit" value="Сохранить" class="btn btn-primary btn-block" onclick="actionSaveObject('<?php echo $siteData->urlBasic.'/cabinet/shop/save'; ?>?', 0, 'edit_panel', false)">
        </div>
    </div>
</section>