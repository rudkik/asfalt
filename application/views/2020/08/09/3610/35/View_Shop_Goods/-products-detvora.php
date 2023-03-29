<?php if (count($data['view::View_Shop_Good\-products-rubriki-v-snizu']->childs) > 0){ ?>
    <div class="col-md-3 box-col">
        <ul class="box-menu">
            <li class="title">
                <h3>Категории</h3>
            </li>
            <?php
            foreach ($data['view::View_Shop_Good\-products-rubriki-v-snizu']->childs as $value){
                echo $value->str;
            }
            ?>
        </ul>
    </div>
<?php } ?>