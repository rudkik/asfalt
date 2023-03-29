<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name": "<?php echo htmlspecialchars($siteData->shop->getName()); ?>",
  "alternateName": "<?php echo htmlspecialchars($siteData->shop->getName()); ?>",
  "url": "<?php echo $siteData->urlBasic; ?>",
  <?php if(! empty($siteData->shop->getImagePath())){ ?>
      "logo": "<?php echo $siteData->shop->getImagePath(); ?>",
  <?php } ?>
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+7-727-380-60-38",
    "email": "press@zakon.kz",
    "contactType": "customer support"
  }],
  "sameAs" : [
	"https://www.facebook.com/zakon.kz/",
	"http://twitter.com/#!/zakon_kaz/",
	"https://plus.google.com/+zakonkz/",
	"http://vk.com/zakonkz/",
	"http://my.mail.ru/community/zakonkzz/",
	"https://www.instagram.com/zakon.kz/",
	"http://www.odnoklassniki.ru/zakon.kz/"
	]
}
</script>