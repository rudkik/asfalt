
<?php if(count($data['view::View_Ads_Shop_Parcel\-account-sent-otpravlennye']->childs)> 0){ ?>
    <!-- Заказ  успешно оплачен -->
    <table class="table table--with_content">
        <thead class="table__head">
            <tr class="table__row">
                <td class="table__col">Заказ №</td>
                <td class="table__col">Вес - Стоимость</td>
                <td class="table__col">Дата отправки</td>
                <!-- <td class="table__col">Пункт самовывоза</td> -->
                <td class="table__col">Получатель</td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data['view::View_Ads_Shop_Parcel\-account-sent-otpravlennye']->childs as $value){
            echo $value->str;
        }
        ?>
        </tbody>
    </table>
    <h4 class="margin-tb-1"><span style="font-weight: 700;">Пункт самовывоза:</span> Республика Казахстан, г. Алматы, ул. Чайкиной 1/1</h4>
<?php }else{ ?>
    <span class="title--block">
        Отправленных посылок пока нет
    </span>
<?php } ?>
