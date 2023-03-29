<?php
$view = View::factory($siteData->shopShablonPath.'/35/find');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<div class="body-cart-shop">
    <div class="container">
        <?php echo trim($data['view::shopbill/edit']); ?>
    </div>
</div>
<!--[if !IE]><!-->
<style>
    @media only screen and (max-width: 720px),(max-device-width: 720px)  {
        .table-column-5 td {
            padding-left: 100px !important;
        }

        .table-column-5 td:first-child{
            background-color: #ddd;
        }
        .table-column-5 td:nth-of-type(1):before { content: "Товар"; }
        .table-column-5 td:nth-of-type(2):before { content: "Кол-во"; }
        .table-column-5 td:nth-of-type(3):before { content: "Цена"; }
        .table-column-5 td:nth-of-type(4):before { content: "Итого"; }
    }
</style>
<!--<![endif]-->