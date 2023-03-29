<?php
switch ($data->values['contact_type_id']){
    case Model_ContactType::CONTACT_TYPE_EMAIL:
        echo 'E-mail: ';
        break;
    case Model_ContactType::CONTACT_TYPE_PHONE:
    case Model_ContactType::CONTACT_TYPE_MOBILE:
        echo 'Телефон: ';
        break;
}
echo Func::getContactHTMLRus($data->values, false, true);
?><br>