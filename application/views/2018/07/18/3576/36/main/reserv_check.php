<header class="header-reserve background" style="background: none">
    <div class="container">
        <h2>Check your booking</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <form action="<?php echo $siteData->urlBasicLanguage;?>/reserv/check" method="get">
            <div class="row box-reserve">
                <div class="col-sm-4"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Booking Code</label>
                        <input name="id" class="form-control" required type="text" value="<?php echo Request_RequestParams::getParamStr('id'); ?>">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="box-finish-reserve">
                        <button type="submit" class="btn btn-flat btn-blue-un" style="margin-top: 7px;" type="submit">Check</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</header>
<header class="header-reserve">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_Hotel_Shop_Bill\reserv_check']); ?>
    </div>
</header>
<header class="header-reserve background">
    <div class="container">
        <h3>Book a Room</h3>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <form action="<?php echo $siteData->urlBasicLanguage;?>/free/room/types" method="get">
            <div class="row box-reserve">
                <div class="col-sm-1"></div>
                <div class="col-sm-2 box-date">
                    <div class="form-group">
                        <label>Check in Date</label>
                        <div class="input-group">
                            <input name="date_from" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_from'); ?>">
                            <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 box-date">
                    <div class="form-group">
                        <label>Check out Date</label>
                        <div class="input-group">
                            <input name="date_to" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_to'); ?>">
                            <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Number of Guests:Adults</label>
                        <select name="adults" class="form-control select2" style="width: 100%;">
                            <?php
                            $select = Request_RequestParams::getParamInt('adults');
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
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Number of Guests: Children 5-12 year olds</label>
                        <select name="childs" class="form-control select2" style="width: 100%;">
                            <?php
                            $select = Request_RequestParams::getParamInt('childs');
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
                <div class="col-sm-2 btn_box">
                    <div class="box-finish-reserve">
                        <button type="submit" class="btn btn-flat btn-blue-un" style="margin-top: 7px;" type="submit">
                            <?php  if(($siteData->url == '/free/room/types') || ($siteData->url == '/free/rooms')){ ?>Change Booking<?php }else{ ?>Book a Room<?php } ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</header>