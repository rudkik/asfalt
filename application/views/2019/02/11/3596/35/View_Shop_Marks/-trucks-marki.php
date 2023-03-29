<?php if(count($data['view::View_Shop_Mark\-trucks-marki']->childs) > 0){ ?>
    <div class="box-filter">
        <h3>Марка</h3>
        <ul class="box-filter-items">
            <?php
            foreach ($data['view::View_Shop_Mark\-trucks-marki']->childs as $value){
                echo $value->str;
            }
            ?>
        </ul>
    </div>
<?php } ?>