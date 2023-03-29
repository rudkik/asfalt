<?php $data = $data['view::kaspi/price-list/one/index']; ?>
<?xml version="1.0" encoding="utf-8"?>
<kaspi_catalog date="string" xmlns="kaspiShopping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="kaspiShopping http://kaspi.kz/kaspishopping.xsd">
    <company><?php echo htmlspecialchars($data->additionDatas['company'], ENT_XML1); ?></company>
    <merchantid><?php echo htmlspecialchars($data->additionDatas['merchantid'], ENT_XML1); ?></merchantid>
    <offers>
        <?php
        foreach ($data->childs as $value) {
            echo $value->str;
        }
        ?>
    </offers>
</kaspi_catalog>