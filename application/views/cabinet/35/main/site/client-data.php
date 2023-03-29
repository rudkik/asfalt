<div class="add-magazin">

    <?php if (Request_RequestParams::getParamInt('id') > 0) { ?>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-default navbar-top" role="navigation">
                        <ul class="nav navbar-nav">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/index?id=<?php echo Request_RequestParams::getParamInt('id');?>">Информация о магазине</a></li>
                                <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/css?id=<?php echo Request_RequestParams::getParamInt('id');?>">CSS</a></li>
                                <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/urls?id=<?php echo Request_RequestParams::getParamInt('id');?>">Ссылки</a></li>
                                <li class="active"><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/clientdata?id=<?php echo Request_RequestParams::getParamInt('id');?>">Данные для заполнения</a></li>
                            </ul>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    <?php } ?>

    <section class="content bg-white" >
        <div class="row">
            <div class="col-md-12">
                <div class="add-magazin-view add-magazin">

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo trim($data['view::site/client-datas']); ?>
                        </div>
                    </div>

                </div>
            </div>
    </section>
</div>

