<?php if(count($data['view::View_Ads_Shop_Parcel\-account-delivered']->childs) > 0){?>
    <div class="col-md-10">
        <div class="title--block margin-tb-1">
            Ваши доставленные посылки
        </div>
        <div class="table__wrap margin-b-1-5">
            <table class="table table--with_content">
                <thead class="table__head">
                <tr class="table__row">
                    <td class="table__col">№ посылки</td>
                    <td class="table__col">Дата заказа</td>
                    <td class="table__col">Дата отправки</td>
                    <td class="table__col">Вес (кг)</td>
                    <td class="table__col">Стоимость доставки</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data['view::View_Ads_Shop_Parcel\-account-delivered']->childs as $value){
                    echo $value->str;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php }else{?>
    <div class="col-sm-10 d-flex d-sm-block justify-content-center">
        <div class="title--block margin-tb-1" style="white-space: nowrap;">
            Доставленных посылок пока нет
        </div>
    </div>
<?php }?>
