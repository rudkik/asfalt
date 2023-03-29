<div class="listar-pricingplans">
<?php
$n = 4;
$i = 1;
foreach ($data['view::View_Shop_Good\packages-pakety']->childs as $value){
    if($i == $n + 1){
        echo '<div class="box_packages_info">Удобно тем, кто самостоятельно заполняет и сдает налоговые отчеты и не имеет сотрудников. Подходит для всех типов компании.</div></div><div class="listar-pricingplans">';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
    <div class="box_packages_info">Закрывает все вопросы, касающиеся бухгалтерии. Идеально подходит для ТОО и ИП на упрощенке и на общеустановленном режиме.</div>
</div>