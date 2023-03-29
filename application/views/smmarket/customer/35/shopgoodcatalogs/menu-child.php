<?php if (count($data['view::shopgoodcatalog/menu-child']->childs)> 0){ ?>
<ul class="dropdown-menu" role="menu" aria-labelledby="drop0">
    <?php
    foreach ($data['view::shopgoodcatalog/menu-child']->childs as $value) {
        echo $value->str;
    }
    ?>
</ul>
<?php } ?>
