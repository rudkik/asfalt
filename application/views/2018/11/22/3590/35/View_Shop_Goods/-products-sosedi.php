<?php if (count($data['view::View_Shop_Good\group\-products-rubriki-v-snizu']->childs) > 0){ ?>
    <div class="container eq_backg">
        <div class="content gadvtext">
            <div class="prouct_category_cont">
                <?php
                foreach ($data['view::View_Shop_Good\group\-products-rubriki-v-snizu']->childs as $value){
                    echo $value->str;
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>

