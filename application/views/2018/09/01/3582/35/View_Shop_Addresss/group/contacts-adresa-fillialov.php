<?php
$emails = array();
$phones = array();
foreach ($data['view::View_Shop_Address\group\contacts-adresa-fillialov']->childs as $value){
    $tmp = json_decode($value->str, TRUE);
    if ($tmp['contact_type_id'] == 98){
        $emails[] = $tmp;
    }elseif (($tmp['contact_type_id'] == 13) || ($tmp['contact_type_id'] == 14)){
        $phones[] = $tmp;
    }
}
?>
<h3 class="contacts__block__links">
    <?php foreach ($emails as $email){ ?>
        <a class="contacts__block__link" href="mailto:<?php echo $email['name']; ?>"><?php echo $email['name']; ?></a>
    <?php } ?>
    <a class="contacts__block__link" href="www.kompressory.kz">www.kompressory.kz</a>
</h3>
<h4 class="contacts__block__tel__wrap">
    <?php foreach ($phones as $phone){ ?>
        <a href="tel:<?php echo $phone['name']; ?>" class="contacts__block__tel">
            <?php echo $phone['name']; ?>
        </a>
    <?php } ?>
</h4>
