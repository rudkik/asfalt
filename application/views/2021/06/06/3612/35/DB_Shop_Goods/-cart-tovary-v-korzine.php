<?php 
foreach ($data['view::DB_Shop_Good\-cart-tovary-v-korzine']->childs as $value){
    echo $value->str;
}
?>
<style>
    .coupon-discount {
        color: #dd4b39;
    }
    @media (min-width: 769px) {
        .coupon-discount {
            margin-top: -18px;
            position: absolute;
            margin-left: 7px;
        }
    }
    @media (max-width: 768px) {
        .coupon-discount {
            margin-left: 10px;
        }
    }
</style>
