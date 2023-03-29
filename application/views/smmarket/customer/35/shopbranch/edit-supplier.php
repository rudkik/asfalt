<h1><?php echo $data->values['name']; ?></h1>
<div class="bill-min"><span>Минимальная сумма заказа</span>  - <label class="price text-red""><?php echo Func::getPriceStr($siteData->currency, Arr::path($data->values, 'options.site_min_bill', ''));?></label></div>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li class="active"><a href="#goods" data-toggle="tab" aria-expanded="false">Продукция</a></li>
                <li class=""><a href="#info" data-toggle="tab" aria-expanded="true">Информация о поставщике</a></li>
                <li class=""><a href="#info-legal-supplier" data-toggle="tab" aria-expanded="true">Юридические данные</a></li>
                <?php
                $partnerStatus = intval(Arr::path($siteData->shop->getOptions(), 'partners_status.'.$data->id, '0'));
                switch($partnerStatus){
                    case 1:
                        echo '<li class="partner-status bg-orange">Ожидаем подтверждение</li>';
                        break;
                    case 2:
                        echo '<li class="partner-status bg-red">Не являетесь мои поставщиком</li>';
                        break;
                    default:
                        echo '<li class="partner-status bg-green">Мой поставщик</li>';
                };
                ?>
            </ul>
            <div class="tab-content no-padding">
                <div class="chart tab-pane active" id="goods">
                    <div class="col-md-12">
                        <?php
                        echo trim($siteData->globalDatas['view::shopgoods/index']);
                        ?>
                    </div>
                </div>
                <div class="chart tab-pane " id="info">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>E-mail</td>
                                <td><?php echo Arr::path($data->values, 'options.site_email', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Сайт</td>
                                <td><?php echo Arr::path($data->values, 'options.site_site', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Телефоны</td>
                                <td>
                                    <?php
                                    $phones = Arr::path($data->values, 'options.site_phones', array());
                                    if((is_array($phones)) && (count($phones))) {
                                        $i = 0;
                                        $s = '';
                                        foreach ($phones as $phone) {
                                            $s = trim(Arr::path($phone, 'phone', '').' '.Arr::path($phone, 'info', '')).', ';
                                        }
                                        echo substr($s, 0, strlen($s) - 2);
                                    }elseif((!is_array($phones))) {
                                        echo $phones;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Адрес</td>
                                <td><?php echo Arr::path($data->values, 'options.site_address', ''); ?></td>
                            </tr>
                            <?php
                            $map = Arr::path($data->values, 'options.site_map', '');
                            if(!empty($map)){
                            ?>
                            <tr>
                                <td>Карта</td>
                                <td style="height: 400px"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor<?php echo $map; ?>&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>Минимальная сумма заказа</td>
                                <td><?php echo Func::getPriceStr($siteData->currency, Arr::path($data->values, 'options.site_min_bill', '0')); ?></td>
                            </tr>
                            <tr>
                                <td>Условия</td>
                                <td><?php echo Arr::path($data->values, 'options.site_delivery', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Время доставки</td>
                                <td><?php echo Arr::path($data->values, 'options.site_time_delivery', ''); ?> ч</td>
                            </tr>
                            <tr>
                                <td>Прочее описание</td>
                                <td><?php echo Arr::path($data->values, 'options.site_comment', ''); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane body-partner-goods" id="info-legal-supplier">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>Юридическое название</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_name', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Юридический адрес</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_address', ''); ?></td>
                            </tr>
                            <tr>
                                <td>БИН/ИИН</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_bin', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Номер счета</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_order', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Банк</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_bank', ''); ?></td>
                            </tr>
                            <tr>
                                <td>БИК</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_bik', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Директор</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_director', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Должность директора</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_position_director', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td><?php echo Arr::path($data->values['options'], 'legal_comment', ''); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="chart tab-pane " id="static">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>