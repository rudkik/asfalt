<table>
    <tr>
        <td style="width:30%">Название</td>
        <td style="width:70%;font-weight: bold"><?php echo $shop['name']; ?></td>
    </tr>
    <tr>
        <td style="width:30%">БИН</td>
        <td style="width:70%;font-weight: bold"><?php echo Arr::path($shop['requisites'], 'bin', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Банковский счет</td>
        <td style="width:70%;font-weight: bold"><?php echo Arr::path($shop['requisites'], 'account', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Банк</td>
        <td style="width:70%;font-weight: bold"><?php echo Arr::path($shop, Model_Basic_BasicObject::FIELD_ELEMENTS.'.requisites_bank_id.name', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%">БИК</td>
        <td style="width:70%;font-weight: bold"><?php echo Arr::path($shop, Model_Basic_BasicObject::FIELD_ELEMENTS.'.requisites_bank_id.bik', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%"><?php echo Arr::path($shop['requisites'], 'director_post', ''); ?></td>
        <td style="width:70%;font-weight: bold"><?php echo Arr::path($shop['requisites'], 'director', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Юридический адрес</td>
        <td style="width:70%;font-weight: bold"><?php echo Arr::path($shop['requisites'], 'address', ''); ?></td>
    </tr>
    <tr>
        <td style="width:30%">Фактический адрес</td>
        <td style="width:70%;font-weight: bold"><?php echo Arr::path($shop['requisites'], 'address_actual', ''); ?></td>
    </tr>
</table>