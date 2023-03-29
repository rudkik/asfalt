<?php if (count($data['view::View_Shop_New\-products-detvora']->childs) > 0){ ?>
    <ul class="box-menu">
        <li>
            <h3>Categories</h3>
            <div class="line-red"></div>
        </li>
        <?php
        foreach ($data['view::View_Shop_New\-products-detvora']->childs as $value){
            echo $value->str;
        }
        ?>
    </ul>
<?php } ?>