<?php
echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', TRUE);
$siteData->replaceDatas['address'] = array(
    "@type" => "PostalAddress",
    "addressLocality" => $data->getElementValue('city_id').', '.$data->getElementValue('land_id'),
    "postalCode" => "",
    "streetAddress" => Helpers_Address::getAddressStr($siteData, $data->values, ', ', FALSE)
);
?>
<div style="display: none" itemscope itemtype="http://schema.org/Organization">
    <span itemprop="name"><?php echo $siteData->shop->getName();?></span>
    Байланыс:
    <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        Мекен жайымыз:
        <span itemprop="streetAddress"><?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', ', FALSE); ?></span>
        <span itemprop="postalCode"> </span>
        <span itemprop="addressLocality"><?php echo $data->getElementValue('city_id').', '.$data->getElementValue('land_id'); ?></span>,
    </div>
    Телефон:<span itemprop="telephone"><?php echo $siteData->replaceDatas['telephone'];?></span>,
    Факс:<span itemprop="faxNumber"></span>,
    Электрондық пошта: <span itemprop="email"></span>
</div>
<script type="application/ld+json">
    <?php
    echo json_encode(
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
            "telephone" => $siteData->replaceDatas['telephone']
        )
    );
    ?>
</script>
