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