<?php
$view = View::factory($siteData->shopShablonPath.'/35/find');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<div class="body-managers-shop">
    <div class="container">
        <h1>Менеджеры</h1>
        <?php echo trim($data['view::shopoperations/index']); ?>
    </div>
</div>
<!--[if !IE]><!-->
<style>
    @media only screen and (max-width: 720px),(max-device-width: 720px)  {
        .table-column-5 td {
            padding-left: 150px !important;
        }
        .table-column-5 td:nth-of-type(1):before { content: "ID"; }
        .table-column-5 td:nth-of-type(2):before { content: "ФИО"; }
        .table-column-5 td:nth-of-type(3):before { content: "E-mail"; }
        .table-column-5 td:nth-of-type(4):before { content: "Телефон"; }
        .table-column-5 td:nth-of-type(7):before { content: ""; }
    }
</style>
<!--<![endif]-->

