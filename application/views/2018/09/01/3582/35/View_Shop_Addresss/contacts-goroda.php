<?php
$cities = array();
foreach ($data['view::View_Shop_Address\contacts-goroda']->childs as $value){
    $tmp = json_decode($value->str, TRUE);
    $cities[$tmp['id']] = $tmp;
}

foreach ($cities as $city){?>
    <div class="btn contacts__cityes">
        <label for="contacts_city-<?php echo $city['id']; ?>" <?php
        $cityID = intval(Request_RequestParams::getParamInt('city_id'));
        if($cityID < 1){
            $cityID = 12;
        }
        if($city['id'] == $cityID){
            echo 'class="active"';
        }?>>
            <a href="<?php echo $siteData->urlBasic; ?>/contacts?city_id=<?php echo $city['id']; ?>">г. <?php echo $city['name']; ?></a>
        </label>
    </div>
<?php } ?>