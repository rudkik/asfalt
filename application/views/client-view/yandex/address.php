<div hidden itemscope itemtype="http://schema.org/Organization">
    <span itemprop="name"><?php echo $siteData->shop->getName();?></span>
    Контакты:
    <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        Адрес:
        <span itemprop="streetAddress"><?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', FALSE); ?></span>
        <span itemprop="postalCode"> </span>
        <span itemprop="addressLocality"><?php echo $data->getElementValue('city_id').', '.$data->getElementValue('land_id'); ?></span>,
    </div>
    Телефон:<span itemprop="telephone"></span>,
    Факс:<span itemprop="faxNumber"></span>,
    Электронная почта: <span itemprop="email"></span>
</div>

<div hidden itemscope itemtype="http://schema.org/LocalBusiness">
    <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <div itemprop="addressLocality">
            <?php echo $data->getElementValue('city_id').', '.$data->getElementValue('land_id'); ?>
        </div>,
        <span itemprop="streetAddress"><?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', FALSE); ?></span>
    </div>
    <a itemprop="telephone" href="tel:"></a>
    <a href="mailto:" itemprop="email"></a>
</div>

<script type="application/ld+json">
    <?php
    json_encode(
        array(
            "@context" => "http://schema.org",
            "@type" => "Organization",
            "address" => array(
                "@type" => "PostalAddress",
                "addressLocality" => $data->getElementValue('city_id').', '.$data->getElementValue('land_id'),
                "postalCode" => "",
                "streetAddress" => Helpers_Address::getAddressStr($siteData, $data->values, ', ', FALSE)
            ),
            "email" => '',
            "faxNumber" => '',
            "member" => array(
                array(
                    "@type" => "Organization"
                ),
                array(
                    "@type" => "Organization"
                )
            ),
            "name" => $siteData->shop->getName(),
            "telephone" => ''
        )
    );
    ?>
</script>