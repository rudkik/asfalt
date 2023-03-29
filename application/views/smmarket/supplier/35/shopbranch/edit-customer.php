<h1><?php echo $data->values['name'];?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom nav-tabs-success">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li class="active"><a href="#site" data-toggle="tab" aria-expanded="true">Данные на сайт</a></li>
                <li><a href="#legal" data-toggle="tab" aria-expanded="false">Юридические данные</a></li>
            </ul>
            <div class="tab-content no-padding box-partner-edit body-partner-goods">
                <div class="tab-pane active" id="site">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>Класс торговой точки</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_branch_catalog_id.name', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Телефоны</td>
                                <td>
                                    <?php
                                    $phones = Arr::path($data->values, 'options.site_phones', array());
                                    if((is_array($phones)) && (count($phones))) {
                                        $s = '';
                                        foreach ($phones as $phone) {
                                            $s = $s . trim(Arr::path($phone, 'phone', '') . ' ' . Arr::path($phone, 'info', '')) . ', ';
                                        }
                                        echo substr($s, 0, strlen($s) - 2);
                                    }elseif((!is_array($phones))) {
                                        echo $phones;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>E-mail</td>
                                <td><?php echo Arr::path($data->values, 'options.site_email', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Адрес</td>
                                <td><?php echo Arr::path($data->values, '$elements$.city_id.name', ''); ?>, <?php echo Arr::path($data->values, 'options.site_address', ''); ?></td>
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
                                <td>Прочее описание</td>
                                <td><?php echo Arr::path($data->values, 'options.site_comment', ''); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="legal">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>Юридическое название</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_name', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Юридический адрес</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_address', ''); ?></td>
                            </tr>
                            <tr>
                                <td>БИН/ИИН</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_bin', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Номер счета</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_order', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Банк</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_bank', ''); ?></td>
                            </tr>
                            <tr>
                                <td>БИК</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_bik', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Директор</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_director', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Должность директора</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_position_director', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td><?php echo Arr::path($data->values, 'options.legal_comment', ''); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>