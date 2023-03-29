<div class="col-sm-10">
    <div class="title--block margin-tb-1" style="display: inline-block;">
        <?php if(count($data['view::View_Ads_Shop_Parcel\-account-stock-na-sklade']->childs)> 0){ ?>
            <?php
            $time = time();
            for ($i = 0; $i < 8; $i++){
                $tmp = $time + 24*60*60* $i;
                if ((strftime('%u', $tmp) == 5) && ($time < (strtotime(date('Y-m-d 12:00:00', $tmp))))){
                    $time = $tmp;
                    break;
                }
            }
            ?>
            Посылки на складе <span style="color:red">(отправка <?php echo date('d.m.Y', $time); ?>)</span>
        <?php }else{ ?>
            Посылок на складе пока нет
        <?php } ?>
    </div>
</div>
<div class="col-sm-10">
    <div class="packages">
    <table class="table table--with_content">
        <thead class="table__head">
            <tr class="table__row">
                <td class="table__col">Заказ №</td>
                <td class="table__col">Вес - Стоимость</td>
                <td class="table__col">Дата отправки</td>
                <!-- <td class="table__col">Пункт самовывоза</td> -->
                <td class="table__col">Трекинг ID</td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data['view::View_Ads_Shop_Parcel\-account-stock-na-sklade']->childs as $value){
            echo $value->str;
        }
        ?>
        </tbody>
    </table>

    </div>
</div>

