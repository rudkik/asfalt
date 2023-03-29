<div class="body-cart-shop">
    <div class="container">
        <h1>Корзина</h1>
        <?php
        foreach ($data['view::shopcart/index']->childs as $value) {
            echo $value->str;
        }
        ?>
    </div>
</div>