<?php if(count($data['view::View_Shop_Good\catalogs-podrubriki']->childs) > 0){ ?>
    <div class="widget woocommerce widget_product_categories techmarket_widget_product_categories" id="techmarket_product_categories_widget-2">
        <ul class="product-categories ">
            <li class="product_cat">
                <span>Категории</span>
                <ul>
                    <?php
                    foreach ($data['view::View_Shop_Good\catalogs-podrubriki']->childs as $value){
                        echo $value->str;
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
<?php } ?>