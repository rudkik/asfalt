<?php
return array(
    array(
        'name' => 'htmlspecialchars',
        'shablon' => array(
            'ru' => '<?php echo htmlspecialchars($data->values[\'name\'], ENT_QUOTES);?>'
        ),
        'title' => array(
            'ru' => 'Подсказка для картинки',
        ),
    ),

    array(
        'name' => 'getContactHTMLRus',
        'shablon' => array(
            'ru' => '<?php echo Func::getContactHTMLRus($data->values, префикс);?>'
        ),
        'title' => array(
            'ru' => 'Контакты (ввиде строки с HTML-кодом)',
        ),
    ),

    array(
        'name' => 'get_in_translate_to_en',
        'shablon' => array(
            'ru' => '<?php echo Func::get_in_translate_to_en(строка);?>'
        ),
        'title' => array(
            'ru' => 'Транслит',
        ),
    ),

    array(
        'name' => 'getPhotoPath',
        'shablon' => array(
            'ru' => '<?php echo Helpers_Image::getPhotoPath($data->values[\'image_path\'], ширина, высота); ?>'
        ),
        'title' => array(
            'ru' => 'Размер картинки',
        ),
    ),

    array(
        'name' => 'getOptimalSizePhotoPath',
        'shablon' => array(
            'ru' => '<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values[\'files\'], ширина, высота, $data->values[\'image_path\']), ширина, высота); ?>'
        ),
        'title' => array(
            'ru' => 'Подбор оптимального размера картинки',
        ),
    ),

    array(
        'name' => 'getAddressStrRus',
        'shablon' => array(
            'ru' => '<?php echo Helpers_Address::getAddressStr($siteData, $data->values, \'разделитель\', TRUE, FALSE); ?>'
        ),
        'title' => array(
            'ru' => 'Адрес одной строкой',
        ),
    ),

    array(
        'name' => 'trimTextNew',
        'shablon' => array(
            'ru' => '<?php echo Func::trimTextNew($data->values[\'text\'], количество); ?>'
        ),
        'title' => array(
            'ru' => 'Текст (обрезать)',
        ),
    ),

    array(
        'name' => '$siteData->urlBasicLanguage',
        'shablon' => array(
            'ru' => '<?php echo $siteData->urlBasicLanguage; ?>/'
        ),
        'title' => array(
            'ru' => 'Ссылка',
        ),
    ),

    array(
        'name' => '$siteData->urlBasic',
        'shablon' => array(
            'ru' => '<?php echo Func::getURL($siteData, \'ссылка\', array(), FALSE); ?>/'
        ),
        'title' => array(
            'ru' => 'Генерируется ссылка',
        ),
    ),

    array(
        'name' => 'Func::getGoodPriceStr',
        'shablon' => array(
            'ru' => '<?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>'
        ),
        'title' => array(
            'ru' => 'Цена товара (с курсом валюты)',
        ),
    ),

    array(
        'name' => 'Func::getGoodAmountStr',
        'shablon' => array(
            'ru' => '<?php echo Func::getGoodAmountStr($siteData->currency, $data, $data->additionDatas[\'count\']); ?>'
        ),
        'title' => array(
            'ru' => 'Стоимость товаров (цена * кол-во)',
        ),
    ),
    array(
        'name' => '$data->getElementValue',
        'shablon' => array(
            'ru' => '<?php echo $data->getElementValue(\'объект\', \'поле\'); ?>'
        ),
        'title' => array(
            'ru' => 'Получить значение со вязанного элемета',
        ),
    ),
    array(
        'name' => '$data->values[\'options\']',
        'shablon' => array(
            'ru' => '<?php echo Arr::path($data->values[\'options\'], \'название\', \'\'); ?>'
        ),
        'title' => array(
            'ru' => 'Получить дополнительное поле',
        ),
    ),
);