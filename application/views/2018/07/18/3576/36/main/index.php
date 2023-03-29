<header class="header-main">
    <div class="container">
        <h2>Our Amenities</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="row box-button">
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue active" data-id="#water" data-action="click-service">Thermal Pools</button>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue" data-id="#home" data-action="click-service">Accommodation</button>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue" data-id="#kitcher" data-action="click-service">Food</button>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue" data-id="#other" data-action="click-service">Other</button>
            </div>
        </div>
        <div id="panels-all">
            <div id="water">
                <div id="carousel-1" class="carousel slide" data-ride="carousel" data-interval="10000">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-basseiny']); ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-1" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div id="home">
                <div id="carousel-2" class="carousel slide" data-ride="carousel" data-interval="10000">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-nomera']); ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-2" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-2" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div id="kitcher">
                <div class="row kitchen">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\-domashnyaya-kukhnya']); ?>
                </div>
            </div>

            <div id="other">
                <div id="carousel-3" class="carousel slide" data-ride="carousel" data-interval="10000">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-drugie-uslugi']); ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-3" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-3" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <script>
            $('[data-action="click-service"]').click(function () {
                $('#panels-all').children().css('display', 'none');
                $($(this).data('id')).css('display', 'block');

                $(this).parent().parent().find('[data-action="click-service"]').removeClass('active');
                $(this).addClass('active');

                return false;
            });
            $('#panels-all').children().css('display', 'none');
            $('#water').css('display', 'block');

        </script>
    </div>
</header>
<header class="header-about">
    <div class="container">
        <h2>About us</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="row">
            <div class="col-sm-4">
                <div class="box-01">
                    <p class="name">Thermal Water</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-l.png">
                    <p class="info">Chundzha Hot Springs are well known for its healing water.  Kara Dala Resort's thermal water is pumped at a depth of 650 meters. Bathing and swimming in our thermal pools contribute to the process of self-regulation of the whole body, which in turn increases its resistance to various diseases. </p>
                </div>
                <div class="box-02">
                    <p class="name">Nature and Relaxation</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-l.png">
                    <p class="info">Far away from a hectic city life, Kara Dala Resort at Chundzha Hot Springs is a refreshing and peaceful oasis surrounded by a wild steppe of Kazakhstan. </p>
                </div>
            </div>
            <div class="col-sm-4">
                <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/m-about.png">
            </div>
            <div class="col-sm-4 text-righr">
                <div class="box-03">
                    <p class="name">Family and Friends</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-r.png">
                    <p class="info">Our resort offers a wide range of solutions to accommodate couples, families with children as well as groups of friends and colleagues. </p>
                </div>
                <div class="box-04">
                    <p class="name">Traditions and Quality</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-r.png">
                    <p class="info">Traditional Uyghur and Kazakh cuisine is cooked with local products by our professional staff.</p>
                </div>

            </div>
        </div>
    </div>
</header>
<header class="header-message">
    <div class="container">
        <h1>More questions?</h1>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <p>Leave us your phone number/Whats App or e-mail. We will contact you!</p>
        <form class="reservation" action="/command/message_add" method="post">
            <div class="row">
                <div class="col-sm-4">
                    <div class="input-group">
                        <input class="form-control input-transparent" name="name" value="" placeholder="Your name">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input class="form-control input-transparent" name="options['email']" value="" placeholder="E-mail" type="email">
                    </div>
                </div>
                <div class="col-sm-4">
                    <input name="text" value="Клиент хочет, чтобы к нему позвонили" hidden="">
                    <input name="type" value="5308" hidden="">
                    <input name="url" value="<?php echo $siteData->urlBasicLanguage; ?>/send-message" hidden="">
                    <button type="submit" class="btn btn-flat btn-blue active">Send</button>
                </div>
            </div>
        </form>
    </div>
</header>

<div id="myModalBox" class="modal fade">
    <div class="modal-dialog" style="margin-top: 150px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Dear Guest!</h4>
            </div>
            <div class="modal-body">
                <p>Welcome to Kara Dala Hot Springs Resort!</p>
                <p>We are happy to inform you that our website <b>www.karadala.kz</b> has up-to-date information about our resort:</p>
                <ul>
                    <li>thermal pools,</li>
                    <li>rooms,</li>
                    <li>café and other amenities.</li>
                </ul>
                <p>It allows you to book a room of your choice 24/7 and pay for it using a bank card. It is easy and convenient!</p>
                <p>Technical support: <a href="mailto:info@karadala.kz">info@karadala.kz</a> or <a href="+7 707 33 55 717">+7 707 33 55 717</a></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#myModalBox").modal('show');
    });
</script>