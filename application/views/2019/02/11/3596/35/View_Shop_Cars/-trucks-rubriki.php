<?php if(count($data['view::View_Shop_Car\-trucks-rubriki']->childs) > 0){ ?>
    <div class="box-filter first">
        <h3>Категория</h3>
        <ul class="box-filter-items">
            <?php
            foreach ($data['view::View_Shop_Car\-trucks-rubriki']->childs as $value){
                echo $value->str;
            }
            ?>
        </ul>
    </div>
<?php } ?>
