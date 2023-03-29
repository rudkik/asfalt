<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ от компании <?php echo $siteData->shop->getName();?></title>
    <style type="text/css">
        #outlook a {padding:0;}
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
        #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
        img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        .image_fix {display:block;}
        p {margin: 0px 0px !important;}
        table td {border-collapse: collapse;}
        table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
        table[class=full] { width: 100%; clear: both; }
        @media only screen and (max-width: 640px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff;
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }
            table[class=devicewidth] {width: 440px!important;text-align:center!important;}
            table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
            table[class="sthide"]{display: none!important;}
            img[class="bigimage"]{width: 420px!important;height:219px!important;}
            img[class="col2img"]{width: 420px!important;height:258px!important;}
            img[class="image-banner"]{width: 440px!important;height:106px!important;}
            td[class="menu"]{text-align:center !important; padding: 0 0 10px 0 !important;}
            td[class="logo"]{padding:10px 0 5px 0!important;margin: 0 auto !important;}
            img[class="logo"]{padding:0!important;margin: 0 auto !important;}
        }
        @media only screen and (max-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff;
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }
            table[class=devicewidth] {width: 280px!important;text-align:center!important;}
            table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
            table[class="sthide"]{display: none!important;}
            img[class="bigimage"]{width: 260px!important;height:136px!important;}
            img[class="col2img"]{width: 260px!important;height:160px!important;}
            img[class="image-banner"]{width: 280px!important;height:68px!important;}
        }
    </style>
</head>
<body>
<div class="block">
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="header">
        <tbody>
        <tr>
            <td>
                <table width="580" bgcolor="#0db9ea" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" hlitebg="edit" shadow="edit">
                    <tbody>
                    <tr>
                        <td>
                            <table width="280" cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth">
                                <tbody>
                                <tr>
                                    <td valign="middle" width="270" style="padding: 10px 0 10px 20px;" class="logo">
                                        <div class="imgpop">
                                            <a href="<?php echo $siteData->urlBasic;?>/"><img src="<?php echo Func::addSiteNameInFilePath($siteData->shop->getImagePath(), $siteData); ?>" alt="logo" border="0" style="display:block; border:none; outline:none; text-decoration:none; max-width: 100px; max-height: 28px;" st-image="edit" class="logo"></a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="280" cellpadding="0" cellspacing="0" border="0" align="right" class="devicewidth">
                                <tbody>
                                <tr>
                                    <td width="270" valign="middle" style="font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;line-height: 24px; padding: 10px 0;" align="right" class="menu" st-content="menu">
                                        <a href="<?php echo $siteData->urlBasic;?>/" style="text-decoration: none; color: #ffffff;">Главная</a>
                                        &nbsp;|&nbsp;
                                        <a href="<?php echo $siteData->urlBasic;?>/contacts" style="text-decoration: none; color: #ffffff;">Контакты</a>
                                    </td>
                                    <td width="20"></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="block">
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fulltext">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#ffffff" width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" modulebg="edit">
                    <tbody>
                    <tr>
                        <td width="100%" height="30"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="540" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                <tbody>
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:center;line-height: 20px;" st-title="fulltext-title">
                                        Заказ №<?php echo $bill['id']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="30"></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<?php foreach($billitems as $billitem){ ?>
    <div class="block">
        <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="leftimage">
            <tbody>
            <tr>
                <td>
                    <table bgcolor="#ffffff" width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" modulebg="edit">
                        <tbody>
                        <tr>
                            <td height="20"></td>
                        </tr>
                        <tr>
                            <td>
                                <table width="540" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <table width="200" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                <tbody>
                                                <tr>
                                                    <td width="200" height="180" align="center">
                                                        <img src="<?php echo Helpers_Image::getPhotoPath($billitem['goods_image_path'], 180, 180); ?>" alt="" border="0" width="180" height="180" style="display:block; border:none; outline:none; text-decoration:none;">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mobilespacing">
                                                <tbody>
                                                <tr>
                                                    <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table width="330" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;" st-title="leftimage-title">
                                                        <?php echo $billitem['goods_name']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100%" height="10"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #666; text-align:left;line-height: 20px;" st-title="leftimage-title">
                                                        <?php echo Func::getNumberStr($billitem['count'], FALSE); ?> шт.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #95a5a6; text-align:left;line-height: 24px;" st-content="leftimage-paragraph">
                                                        <?php echo Func::trimTextNew($billitem['goods_text'], 124); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table height="30" align="left" valign="middle" border="0" cellpadding="0" cellspacing="0" class="tablet-button" st-button="edit">
                                                            <tbody>
                                                            <tr>
                                                                <td width="auto" align="center" valign="middle" height="30" style=" background-color:#0db9ea; border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px;">
                                                                <span style="color: #ffffff; font-weight: 300;">
                                                                    <a style="color: #ffffff; text-align:center;text-decoration: none;"><?php echo Func::getPriceStr($siteData->currency, $billitem['amount']); ?></a>
                                                                </span>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php } ?>

<div class="block">
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fulltext">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#ffffff" width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" modulebg="edit">
                    <tbody>
                    <tr>
                        <td width="100%" height="30"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="540" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                <tbody>
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:right;line-height: 20px;" st-title="fulltext-title">
                                        <span>Итого: </span>
                                        <span style=" background-color:#0db9ea; border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; color: #ffffff; font-weight: 300; padding-top:7.5px; padding-bottom:7.5px;">
                                            <a style="color: #ffffff; text-align:center;text-decoration: none;"><?php echo Func::getPriceStr($siteData->currency, $bill['amount']); ?></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="30"></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="block">
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fullimage">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#ffffff" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit">
                    <tbody>
                    <tr>
                        <td width="100%" height="20"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                <tbody>
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;" st-title="rightimage-title">
                                        Доставка
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #666666; text-align:left;line-height: 24px;" st-content="rightimage-paragraph">
                                        <?php echo $bill['delivery_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;" st-title="rightimage-title">
                                        Оплата
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #666666; text-align:left;line-height: 24px;" st-content="rightimage-paragraph">
                                        <?php echo $bill['paid_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>