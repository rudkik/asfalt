<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<body>
<div style="font-family: sans-serif;font-weight: 400;color: #000;line-height: 1.41;font-size: 14px; max-width: 100%; box-shadow: -18px 0px 20px -20px #333, 18px 0px 20px -20px #333;">
    <div>
        <div style=" margin-right: auto; margin-left: auto;">
            <h2 style="font-weight: 500;line-height: 1.1;color: inherit; text-align: center; margin: 10px 0px 20px"><?php echo Arr::path($data, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_subscribe_catalog_id.name', ''); ?></h2>
        </div>
    </div>
    <div>
        <div style=" padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;">
            <div style="display: inline-block;width: 100%;">
                <div style="position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;width: calc(100% - 20px);display: inline-block;margin-bottom: 10px;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #00a65a;">
                    <h3 style="font-weight: 500;line-height: 1.1;color: inherit;font-family: 'Source Sans Pro',sans-serif;font-size: 24px;margin-top: 20px;margin-bottom: 20px;">Данные</h3>
                    <table style="width: 100%;max-width: 100%;margin-bottom: 20px;background-color: transparent;border-spacing: 0;border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;vertical-align: middle;font-weight: 600;width: 250px;">
                                E-mail
                            </td>
                            <td style="padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;vertical-align: middle;">
                                <?php echo $data['name'];?> [<a href="mailto:<?php echo $data['email']; ?>"><?php echo $data['email'];?></a>]
                            </td>
                        </tr>
                        <?php
                        $options = Arr::path($data, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_subscribe_catalog_id.options', array());
                        foreach($options as $option){
                        ?>
                        <tr>
                            <td style="padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;vertical-align: middle;font-weight: 600;width: 250px;">
                                <?php echo $option['title']; ?>
                            </td>
                            <td style="padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;vertical-align: middle;">
                                <?php
                                $s = Arr::path($data['options'], $option['field'], '');
                                if(strpos($s, ' http://') !== FALSE){
                                    $s = '<a href="'.$s.'">'.$s.'</a>';
                                }
                                echo $s;
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div style=" padding: 25px 15px; margin-right: auto; margin-left: auto; font-size: 14px">
            <?php echo $data['text']; ?>
        </div>
    </div>
</div>
</body>
</html>
