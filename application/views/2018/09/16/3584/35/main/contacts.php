<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="type-page hentry">
            <header class="entry-header">
                <div class="page-header-caption">
                    <h1 class="entry-title">Контакты</h1>
                </div>
            </header>
            <div class="entry-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-block">
                            <h2 class="contact-page-title">Оставьте нам сообщение</h2>
                        </div>
                        <div class="contact-form">
                            <div role="form" class="wpcf7" id="wpcf7-f425-o1" dir="ltr" lang="en-US">
                                <div class="screen-reader-response"></div>
                                <form action="<?php echo $siteData->urlBasic;?>/command/message_add" class="wpcf7-form" method="post">
                                    <div class="form-group">
                                        <label>Имя</label>
                                        <br>
                                        <span class="wpcf7-form-control-wrap subject">
                                            <input aria-invalid="false" class="wpcf7-form-control wpcf7-text input-text" size="40" value="" name="name" type="text">
                                        </span>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-md-6">
                                            <label>
                                                Телефон
                                                <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <br>
                                            <span class="wpcf7-form-control-wrap last-name">
                                                <input aria-invalid="false" aria-required="true" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" size="40" value="" name="phone" type="text">
                                            </span>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <label>
                                                E-mail
                                                <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <br>
                                            <span class="wpcf7-form-control-wrap first-name">
                                                <input aria-invalid="false" aria-required="true" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required input-text" size="40" value="" name="email" type="text">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Сообщение</label>
                                        <br>
                                        <span class="wpcf7-form-control-wrap your-message">
                                            <textarea aria-invalid="false" class="wpcf7-form-control wpcf7-textarea" rows="10" cols="40" name="text"></textarea>
                                        </span>
                                    </div>
                                    <div class="form-group clearfix">
                                        <p>
                                            <input value="Отправить" class="wpcf7-form-control wpcf7-submit" type="submit">
                                        </p>
                                    </div>
                                    <div class="wpcf7-response-output wpcf7-display-none"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 store-info store-info-v2">
                        <div class="kc-elm kc-css-773435 kc_text_block">
                            <h2 class="contact-page-title">Контакты</h2>
                            <p>
								<?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\contacts-kontakty']); ?>
                            </p>
                            <h3>Время работы:</h3>
                            <p class="operation-hours">
                                Понедельник - Пятница: 09:00-18:00
                            </p>
                            <h3>Написать</h3>
                            <p><?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\contacts-e-mail']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>