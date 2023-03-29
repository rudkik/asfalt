<?php
$i = 0;
$options = array();
foreach ($data['view::View_Shop_Good\-goods-tovary-dlya-sravneniya']->childs as $value){
    $value->str = json_decode($value->str, TRUE);

    if($i == 0){
        foreach ($value->str['option_keys'] as $k => $v){
            $options[$k] = $v;
        }

        $i++;
    }else{
        foreach ($options as $k){
            if(!key_exists($k, $value->str['option_keys'])){
                unset($options[$key]);
            }
        }
    }
}
?>
<div class="box-compare">
    <table class="table table-compare" style="min-width: <?php echo (count($data['view::View_Shop_Good\-goods-tovary-dlya-sravneniya']->childs) + 1) * 180; ?>px">
        <tbody>
        <tr>
            <td>
                <h3>Сравнение<br> товаров</h3>
                <div class="line-red"></div>
            </td>
            <?php foreach ($data['view::View_Shop_Good\-goods-tovary-dlya-sravneniya']->childs as $value){ ?>
                <td>
                    <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $value->str['name_url']; ?>"><img class="img-goods" src="<?php echo Helpers_Image::getPhotoPath($value->str['image_path'], 191, 191); ?>"></a>
                    <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $value->str['name_url']; ?>" class="name"><?php echo $value->str['name']; ?></a>
                </td>
            <?php } ?>
        </tr>
        <?php foreach ($options as $k => $v){ ?>
            <tr>
                <td><?php echo $v; ?></td>
                <?php foreach ($data['view::View_Shop_Good\-goods-tovary-dlya-sravneniya']->childs as $value){ ?>
                    <td><?php echo $value->str['options'][$k]; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>