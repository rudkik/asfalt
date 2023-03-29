<?php
$one = [];
$two = [];
foreach (Arr::path($data->values['options'], 'fields', array()) as $key => $option) {
    if (!empty($option['title'])) {
        if (key_exists($option['title'], $one)) {
            $one[$option['title']]['colspan']++;
        } else {
            $one[$option['title']] = [
                'title' => $option['title'],
                'is_two' => false,
                'colspan' => 1,
                'color' => false,
                'quantity_value' => $option['quantity_value'],
            ];
        }
        $two[] = [
            'title' => $option['title'],
            'name' => $option['name'],
            'color' => false,
            'colspan' => $option['quantity_value'],
        ];
    } else {
        $one[$option['name']] = [
            'title' => $option['name'],
            'is_two' => true,
            'colspan' => 1,
            'color' => false,
            'quantity_value' => $option['quantity_value'],
        ];
    }
}
$i = 0;
foreach ($one as $key => $child){
    $i++;
    if ($i % 2){
        $one[$key]['color'] = true;
        foreach ($two as $key2 => $child2){
            if ($key == $child2['title']){
                $two[$key2]['color'] = true;
            }
        }
    }
}

$isTwo = count($two) > 0;
//echo '<pre>';
//print_r($two);
//
//die();
?>
<style>
    table tr:nth-child(1) > th:nth-child(2), table tr > td:nth-child(2){
        background-color: rgba(97, 206, 268, 0.6);
    }
    <?php $i= 3;  foreach ($one as $child){
        $i++;
         if ($child['color'] == true){?>
    table tr:nth-child(1) > th:nth-child(<?php echo $i?>), <?php ?>table tr:nth-child(1) > td:nth-child(<?php echo $i?>){
        background-color: rgba(97, 206, 268, 0.6);
    }
    
    <?php } } ?>
</style>
<tr>
    <th <?php if ($isTwo) { ?>rowspan="2"<?php } ?> >
        <a href="<?php echo Func::getFullURL($siteData, '/shopanalysis/index'). Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">№ Пробы</a>
    </th>
    <th <?php if ($isTwo) { ?>rowspan="2"<?php } ?> >
        <a href="<?php echo Func::getFullURL($siteData, '/shopanalysis/index'). Func::getAddURLSortBy($siteData->urlParams, 'sample_at'); ?>" class="link-black">Время отбора пробы</a>
    </th>
    <th <?php if ($isTwo) { ?>rowspan="2"<?php } ?> >
        <a href="<?php echo Func::getFullURL($siteData, '/shopanalysis/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_analysis_place_id.name'); ?>" class="link-black">Место пробы</a>
    </th>
    <?php foreach ($one as $child){ ?>
        <th class="text-center" colspan="<?php if ($child['quantity_value'] != ''){ if ($child['colspan'] == 1){ echo 2; }else{ echo $child['colspan'] + 2; }}else{ echo $child['colspan']; } ?>" <?php if ($child['is_two']) { ?>rowspan="2" <?php } ?>><?php echo $child['title'] ?></th>
    <?php } ?>
    <th <?php if ($isTwo) { ?>rowspan="2"<?php } ?> >
        <a href="<?php echo Func::getFullURL($siteData, '/shopanalysis/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_worker_id.name'); ?>" class="link-black">Работник</a>
    </th>
    <th rowspan="2"></th>
</tr>
<?php if ($isTwo) { ?>
    <tr>
        <?php foreach ($two as $child){ ?>
            <th class="text-center" colspan="<?php if ($child['colspan'] != ''){ echo 2;} ?>"><?php echo $child['name']; ?></th>
        <?php } ?>
    </tr>
<?php } ?>

