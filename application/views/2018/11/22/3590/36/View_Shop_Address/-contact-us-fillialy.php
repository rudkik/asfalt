<div id="panel<?php echo $data->values['id']; ?>" class="tab-pane fade in">
    <div class="text">
		<p><?php echo Helpers_Address::getAddressStr($siteData, $data->values, '<br>', TRUE, TRUE); ?></p>
        <?php echo $data->additionDatas['view::View_Shop_Addresss\group\-contact-us-fillialy']; ?>
        <div><?php echo $data->values['map_data']; ?></div>
    </div>
    <div itemscope itemtype="http://schema.org/Organization" style="display: none">
        <span itemprop="name">Yandex</span>
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <span itemprop="streetAddress"><?php echo Helpers_Address::getAddressStr($siteData, $data->values, '<br>', FALSE, FALSE); ?></span>
            <span itemprop="postalCode"></span>
            <span itemprop="addressLocality"><?php echo $data->getElementValue('city_id'); ?></span>,
        </div>
    </div>
</div>