<?php
$type = $data['view::_shop/bill/one/menu']->additionDatas['type'];
if (count($data['view::_shop/bill/one/menu']->childs) > 0 ){ ?>
<li id="bill-<?php echo $type; ?>" data-count="<?php echo count($data['view::_shop/bill/one/menu']->childs); ?>" class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-shopping-cart"></i>
        <span class="label label-success"><?php echo count($data['view::_shop/bill/one/menu']->childs); ?></span>
    </a>
    <ul class="dropdown-menu">
        <li class="header"><?php echo Func::getCountElementStrRus(count($data['view::_shop/bill/one/menu']->childs), 'заказов', 'заказ', 'заказа'); ?></li>
        <li>
            <ul class="menu">
                <?php
                foreach ($data['view::_shop/bill/one/menu']->childs as $value) {
                    echo $value->str;
                }
                ?>
            </ul>
        </li>
        <li class="footer"><a href="<?php echo $siteData->urlBasic; ?>/cabinet/shopbill/index?type=<?php echo $type; ?>">Все заказы</a></li>
    </ul>
</li>
<?php } ?>