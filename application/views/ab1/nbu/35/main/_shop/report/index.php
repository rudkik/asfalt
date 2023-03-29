<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/nbu/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>НБ01 Уведомление о приеме и сдачи цистерн</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopreport/boxcar_drain'); ?>" method="get" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="boxcar_drain-date_from">Дата убытия вагона от</label>
                                <input id="boxcar_drain-date_from" class="form-control" name="date_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="boxcar_drain-date_to">Дата убытия вагона до</label>
                                <input id="boxcar_drain-date_to" class="form-control" name="date_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_boxcar_client_id">Поставщик</label>
                                <select id="shop_boxcar_client_id" name="shop_boxcar_client_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите поставщика</option>
                                    <?php echo $siteData->globalDatas['view::_shop/boxcar/client/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="shop_raw_id">Сырье</label>
                                <select id="shop_raw_id" name="shop_raw_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Выберите сырье</option>
                                    <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary">Отчет</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-2">
                <div class="box-barrel">
                    <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: 40%; position: absolute;
width: 100%;">                        <span>40% / 1155 т</span>
                    </div>
                    <img src="<?php echo $siteData->urlBasic; ?>/css/ab1/img/barrel.png">
                </div>
            </div>
            <style>
                .box-barrel{
                    height: 207px;
                    width: 150px;
                    margin: 0px 15px 30px 15px;
                    position: inherit;
                }
                .box-barrel > img{
                    width: 100%;
                    position: absolute;
                }
                .box-barrel > .progress-bar{
                    width: 100%;
                    position: absolute;
                    bottom: 0;
                }
            </style>
        </div>
	</div>
</div>