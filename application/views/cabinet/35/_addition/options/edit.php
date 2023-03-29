<?php
if(empty($optionsName)){
    $optionsName = 'options';
}

if(! is_array($fields)){
    $fields = array();
}

$values = Arr::path($data->values, $optionsName, array());
if(! is_array($values)){
    $values = array();
}
foreach ($fields as $field){
    $value = Arr::path($values, $field['field'], '');

    if(key_exists($field['field'], $values)){
        unset($values[$field['field']]);
    }

?>
    <div class="row record-input <?php echo $className; ?>">
        <div class="col-md-3 record-title">
            <?php if(Arr::path($field, 'type', 0) != Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX){ ?>
            <label>
                <?php echo $field['title']; ?>
                <?php if(!Func::_empty(Arr::path($field, 'hint', ''))){ ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                <?php } ?>
            </label>
            <?php } ?>
            <?php if(intval(Arr::path($field, 'type', 0)) == Model_Shop_Basic_Options::OPTIONS_TYPE_TABLE){ ?>
                <div class="row">
                    <div class="col-md-12 record-title text-right">
                        <a href="#" data-action="copy-server" data-parent="#option-param-<?php echo $field['field']; ?>" data-name="options.<?php echo $field['field']; ?>" data-language="<?php echo $siteData->dataLanguageID; ?>">Копировать</a><br>
                        <a href="#" data-action="insert-server" data-parent="#option-param-<?php echo $field['field']; ?>" data-name="options.<?php echo $field['field']; ?>" data-language="<?php echo $siteData->dataLanguageID; ?>">Вставить</a><br>
                        <a href="#" data-action="insert-server" data-replace="1" data-parent="#option-param-<?php echo $field['field']; ?>" data-name="options.<?php echo $field['field']; ?>" data-language="<?php echo $siteData->dataLanguageID; ?>">Заменить</a><br><br>
                        <a href="#" data-action="copy-server" data-parent="#option-param-<?php echo $field['field']; ?>" data-name="options.<?php echo $field['field']; ?>" data-language="0">Копировать без языка</a><br>
                        <a href="#" data-action="insert-server" data-parent="#option-param-<?php echo $field['field']; ?>" data-name="options.<?php echo $field['field']; ?>" data-language="0">Вставить без языка</a><br>
                        <a href="#" data-action="insert-server" data-replace="1" data-parent="#option-param-<?php echo $field['field']; ?>" data-name="options.<?php echo $field['field']; ?>" data-language="0">Заменить без языка</a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-9">
            <?php switch(intval(Arr::path($field, 'type', 0))){
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX): ?>
                    <span class="span-checkbox" style="padding-top: 7px;"><input name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]"  type="checkbox" class="minimal" <?php if($value == 1){echo 'checked value="1"';}else{echo 'value="0"';} ?>> <?php echo $field['title']; ?></span>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA): ?>
                    <textarea name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]" placeholder="<?php echo htmlspecialchars($field['title'], ENT_QUOTES);?>" rows="<?php echo Arr::path($field, 'options.rows', 2) *1 ;?>" class="form-control"><?php echo $value; ?></textarea>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_FILE): ?>
                    <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                        <input type="file" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]" >
                    </div>
                    <?php if (!empty($value)){ ?>
                    <a href="<?php echo Func::addSiteNameInFilePath(Arr::path($value, 'file', ''), $siteData); ?>">Скачать файл</a>
                    <?php } ?>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA_HTML): ?>
                    <textarea name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]" placeholder="<?php echo htmlspecialchars($field['title'], ENT_QUOTES);?>" rows="<?php echo Arr::path($field, 'options.rows', 7) *1 ;?>" class="form-control"><?php echo $value; ?></textarea>
                    <script>
                        CKEDITOR.replace('<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]');
                    </script>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_MAP_YANDEX):
                    if(! is_array($value)){
                        $value = array();
                    }
                ?>
                    <div id="map-yandex" style="height: 333px; width: 100%; border: 1px solid #ccc;"></div>
                    <div style="display: none;">
                        <input id="options-<?php echo $field['field']; ?>-x" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][x]" value="<?php echo htmlspecialchars(Arr::path($value, 'x', ''), ENT_QUOTES); ?>">
                        <input id="options-<?php echo $field['field']; ?>-y" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][y]" value="<?php echo htmlspecialchars(Arr::path($value, 'y', ''), ENT_QUOTES); ?>">
                        <input id="options-<?php echo $field['field']; ?>-zoom" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][zoom]" value="<?php echo htmlspecialchars(Arr::path($value, 'zoom', ''), ENT_QUOTES); ?>">
                        <input id="options-<?php echo $field['field']; ?>-map-center-x" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][map_center_x]" value="<?php echo htmlspecialchars(Arr::path($value, 'map_center_x', ''), ENT_QUOTES); ?>">
                        <input id="options-<?php echo $field['field']; ?>-map-center-y" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][map_center_y]" value="<?php echo htmlspecialchars(Arr::path($value, 'map_center_y', ''), ENT_QUOTES); ?>">
                    </div>
                    <link href="<?php echo $siteData->urlBasic; ?>/css/_component/yandex-maps/css/yandex-style.css" rel="stylesheet" />
                    <script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
                    <script type="text/javascript">
                        var myMap, myPlacemark, coords;
                        ymaps.ready(init);

                        function init () {
                            myMap = new ymaps.Map('map-yandex', {
                                center: [<?php echo Arr::path($value, 'map_center_x', 43.2311);?>, <?php echo Arr::path($value, 'map_center_y', 76.8770);?>],
                                zoom: <?php echo Arr::path($value, 'zoom', 9);?>,
                                behaviors: ['default', 'scrollZoom']
                            });

                            //Определяем элемент управления поиск по карте
                            var SearchControl = new ymaps.control.SearchControl({noPlacemark:true});

                            //Добавляем элементы управления на карту
                            myMap.controls
                                .add(SearchControl)
                                .add('zoomControl')
                                .add('typeSelector');

                            coords = [<?php echo Arr::path($value, 'x', 43.2244);?>, <?php echo Arr::path($value, 'y', 76.8622);?>];

                            //Определяем метку и добавляем ее на карту
                            myPlacemark = new ymaps.Placemark([<?php echo Arr::path($value, 'x', 43.2244);?>, <?php echo Arr::path($value, 'y', 76.8622);?>],{}, {preset: "twirl#redIcon", draggable: true});
                            myMap.geoObjects.add(myPlacemark);

                            //Отслеживаем событие перемещения метки
                            myPlacemark.events.add("dragend", function (e) {
                                coords = this.geometry.getCoordinates();
                                savecoordinats();
                            }, myPlacemark);

                            //Отслеживаем событие щелчка по карте
                            myMap.events.add('click', function (e) {
                                coords = e.get('coordPosition');
                                savecoordinats();
                            });

                            //Отслеживаем событие выбора результата поиска
                            SearchControl.events.add("resultselect", function (e) {
                                coords = SearchControl.getResultsArray()[0].geometry.getCoordinates();
                                savecoordinats();
                            });

                            //Ослеживаем событие изменения области просмотра карты - масштаб и центр карты
                            myMap.events.add('boundschange', function (event) {
                                if (event.get('newZoom') != event.get('oldZoom')) {
                                    savecoordinats();
                                }
                                if (event.get('newCenter') != event.get('oldCenter')) {
                                    savecoordinats();
                                }
                            });
                        }

                        //Функция для передачи полученных значений в форму
                        function savecoordinats (){
                            var new_coords = [coords[0].toFixed(4), coords[1].toFixed(4)];
                            myPlacemark.getOverlay().getData().geometry.setCoordinates(new_coords);
                            document.getElementById("options-<?php echo $field['field']; ?>-x").value = coords[0].toFixed(4);
                            document.getElementById("options-<?php echo $field['field']; ?>-x").setAttribute('value', coords[0].toFixed(4));
                            document.getElementById("options-<?php echo $field['field']; ?>-y").value = coords[1].toFixed(4);
                            document.getElementById("options-<?php echo $field['field']; ?>-y").setAttribute('value', coords[1].toFixed(4));

                            document.getElementById("options-<?php echo $field['field']; ?>-zoom").value = myMap.getZoom();
                            document.getElementById("options-<?php echo $field['field']; ?>-zoom").setAttribute('value', myMap.getZoom());

                            var center = myMap.getCenter();
                            document.getElementById("options-<?php echo $field['field']; ?>-map-center-x").value = center[0].toFixed(4);
                            document.getElementById("options-<?php echo $field['field']; ?>-map-center-x").setAttribute('value', center[0].toFixed(4));
                            document.getElementById("options-<?php echo $field['field']; ?>-map-center-y").value = center[1].toFixed(4);
                            document.getElementById("options-<?php echo $field['field']; ?>-map-center-y").setAttribute('value', center[1].toFixed(4));
                        }
                    </script>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_TABLE):
                if(! is_array($value)){
                    $value = array();
                }
                ?>
                    <input name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]" value="" style="display: none">
                    <div id="option-param-<?php echo $field['field']; ?>"  action="" method="post" style="overflow: auto;">
                        <table  style="min-width: <?php echo count($field['options']) * 150; ?>px;" id="body_panel-<?php echo $field['field'];?>" class="table table-hover table-db" data-id="<?php echo count($value) + 1;?>">
                            <tr>
                                <th class="tr-header-public">
                                    <span>
                                        <input type="checkbox" class="minimal" checked disabled>
                                    </span>
                                </th>
                                <?php foreach ($field['options'] as $tr){ ?>
                                    <th>
                                        <?php echo $tr['title']; ?>
                                    </th>
                                <?php } ?>
                                <th class="tr-header-buttom"></th>
                            </tr>
                            <?php
                            $i = -1;
                            foreach ($value as $v){
                                $i++;
                                ?>
                                <tr>
                                    <td>
                                        <input data-id="is_public" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][<?php echo $i; ?>][is_public]"
                                            <?php if (Arr::path($v, 'is_public', '') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal" data-id="1" style="width: 25px;">
                                    </td>
                                    <?php foreach ($field['options'] as $tr){ ?>
                                        <td>
                                            <input data-id="<?php echo $tr['field']; ?>" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][<?php echo $i; ?>][<?php echo $tr['field']; ?>]"
                                                   type="text" class="form-control" placeholder="<?php echo htmlspecialchars($tr['title'], ENT_QUOTES); ?>"
                                                   value="<?php echo htmlspecialchars(Arr::path($v, $tr['field'], ''), ENT_QUOTES); ?>">
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <ul class="list-inline tr-button delete">
                                            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="text-right" style="margin: 15px 0px;">
                        <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel-<?php echo $field['field'];?>', 'tr_panel-<?php echo $field['field'];?>', 'div-not-options-options')"><i class="fa fa-fw fa-plus"></i> Добавить</button>
                    </div>
                    <div hidden="hidden" id="tr_panel-<?php echo $field['field'];?>">
                        <!--
                        <tr>
                            <td>
                                <input data-id="is_public" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][#index#][is_public]" value="1" checked type="checkbox" class="minimal" data-id="1" style="width: 25px;">
                            </td>
                            <?php foreach ($field['options'] as $tr){ ?>
                                <td>
                                    <input data-id="<?php echo $tr['field']; ?>" name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>][#index#][<?php echo $tr['field']; ?>]"
                                        type="text" class="form-control" placeholder="<?php echo htmlspecialchars($tr['title'], ENT_QUOTES); ?>"
                                        value="">
                                </td>
                            <?php } ?>
                            <td>
                                <ul class="list-inline tr-button delete">
                                    <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                         -->
                    </div>
                <?php
                break;
                default: ?>
                <input name="<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]" type="text" class="form-control" placeholder="<?php echo htmlspecialchars($field['title'], ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
            <?php } ?>
        </div>
    </div>
<?php }?>
<?php
if ((! empty($isAddNotField)) && ($isAddNotField === TRUE)){
// выводим оставшиеся
foreach ($values as $name => $value){
    ?>
    <div class="row record-input <?php echo $className; ?>">
        <div class="col-md-3 record-title">
            <label>
                <?php echo $name; ?>
            </label>
        </div>
        <div class="col-md-9">
            <input name="<?php echo $optionsName; ?>[<?php echo $name; ?>]" type="text" class="form-control" placeholder="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
        </div>
    </div>
<?php } }?>

