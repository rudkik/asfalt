<header class="header-reserve">
    <div class="container">
        <h3>Забронировать номер</h3>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <form action="<?php echo $siteData->urlBasicLanguage;?>/free/room/types" method="get">
            <div class="row box-reserve">
                <div class="col-sm-1"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Дата заезда</label>
                        <div class="input-group">
                            <input name="date_from" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_from'); ?>">
                            <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Дата выезда</label>
                        <div class="input-group">
                            <input name="date_to" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_to'); ?>">
                            <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Количество взрослых (от 15 лет)</label>
                        <select name="adults" class="form-control select2" style="width: 100%;">
                            <?php
                            $select = 1;
                            for ($i=1; $i <= 30; $i++){
                                if ($i == $select){
                                    echo '<option selected="selected">' . $i . '</option>';
                                }else {
                                    echo '<option>' . $i . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>детей (c 5 до 12 лет)</label>
                        <select name="childs" class="form-control select2" style="width: 100%;">
                            <?php
                            $select = 0;
                            for ($i=0; $i <= 10; $i++){
                                if ($i == $select){
                                    echo '<option selected="selected">' . $i . '</option>';
                                }else {
                                    echo '<option>' . $i . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="box-finish-reserve"><button type="submit" class="btn btn-flat btn-blue-un" type="submit">Найти номер</button></div>
                </div>
            </div>
        </form>
    </div>
</header>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css1">
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js1"></script>
<script>
    $(".select2").select2();
</script>
<?php
$view = View::factory($siteData->shopShablonPath.'/35/maps');
$view->siteData = $siteData;
echo Helpers_View::viewToStr($view);
?>