<?php if (count($data['view::View_ShopGood\catalog_tovary-kategorii']->childs) > 0){?>
    <div class="header header-select-product">
        <div class="container">
            <h2>Актуально сейчас в <?php echo Func::getStringCaseRus($siteData->city->getName(), 5); ?></h2>
            <div class="row products products-row-one">
                <?php
                foreach ($data['view::View_ShopGood\catalog_tovary-kategorii']->childs as $value){
                    echo $value->str;
                }
                ?>
            </div>
        </div>
    </div>
<?php }?>