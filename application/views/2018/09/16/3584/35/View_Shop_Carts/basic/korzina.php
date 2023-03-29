<ul id="site-header-cart" class="site-header-cart menu">
    <li class="animate-dropdown dropdown ">
        <a class="cart-contents" href="cart.html" data-toggle="dropdown" title="View your shopping cart">
            <i class="tm tm-shopping-bag"></i>
            <span class="count"><?php echo trim($siteData->globalDatas['view::shopcart_count']); ?></span>
            <span class="amount"><span class="price-label">Корзина</span><?php echo trim($siteData->globalDatas['view::shopcart_amount_str']); ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-mini-cart">
            <li>
                <div class="widget woocommerce widget_shopping_cart">
                    <div class="widget_shopping_cart_content">
                        <ul class="woocommerce-mini-cart cart_list product_list_widget ">
							<?php 
							foreach ($data['view::View_Shop_Cart\basic\korzina']->childs as $value){
								echo $value->str;
							}
							?>
                        </ul>
                        <p class="woocommerce-mini-cart__total total">
                            <strong>Итого:</strong>
                            <span class="woocommerce-Price-amount amount">
                                <?php echo trim($siteData->globalDatas['view::shopcart_amount_str']); ?>
                            </span>
                        </p>
                        <p class="woocommerce-mini-cart__buttons buttons">
                            <a href="<?php echo $siteData->urlBasic; ?>/cart" class="button wc-forward">В корзину</a>
                            <a href="<?php echo $siteData->urlBasic; ?>/cart/pay" class="button checkout wc-forward">К оплате</a>
                        </p>
                    </div>
                </div>
            </li>
        </ul>
    </li>
</ul>