<table>
    <tr>
        <td>ИНФОРМАЦИЯ О БРОНИ</td>
        <td style="text-align: right"><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['created_at']); ?></td>
    </tr>
</table>
<p style="text-align: center">Уважаемый Гость!</p>
<p style="text-align: justify">Благодарим Вас за то, что Вы забронировали номер(а) на базе отдыха «Кара Дала»! Пожалуйста, в срок до <b><u><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['limit_time']); ?></u></b> оплатите Ваш заказ в размере от 20% до 100% его полной стоимости. Остаток суммы нужно будет оплатить перед заселением в номер. <b>В случае неуплаты в указанный срок, Ваша бронь будет отменена!</b></p>
<p style="text-align: center"><b>КОД БРОНИ:</b> <b style="font-size: 20px"><?php echo $bill['id']; ?></b></p>
<table style="font-weight: bold">
    <tr>
        <td style="width:20%">Гость:</td>
        <td style="width:80%"><?php echo Arr::path($bill, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Дата заезда:</td>
        <td style="width:80%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_from']); ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Дата отъезда:</td>
        <td style="width:80%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_to']); ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Номер(а):</td>
        <td style="width:80%"><?php echo $rooms; ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Сумма заказа:</td>
        <td style="width:80%"><?php echo Func::getNumberStr($bill['amount'], TRUE, 0); ?> тенге<br></td>
    </tr>
    <tr>
        <td style="width:20%">Оплатить до <br><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['limit_time']); ?>:</td>
        <td style="width:80%"><?php echo Func::getNumberStr($bill['amount'] - $bill['paid_amount'], TRUE, 0); ?> тенге<br></td>
    </tr>
</table>
<br><br>
<table border="1px" cellpadding="5">
    <tr>
        <td>Оплачивая бронь номера(ов), Вы соглашаетесь с Правилами обслуживания и размещения гостей на базе отдыха «Кара Дала», опубликованными на сайте <a href="https://karadala.kz">www.karadala.kz</a>
			<p><b>ВАЖНО!</b> Бесплатно изменить/отменить бронь можно при условии наличия номеров, запрашиваемых на новые даты, и только если Вы обратились в срок не позднее 72-х часов до времени заезда по брони. Если бронь была оплачена полностью или частично, то сумма полученной оплаты будет возвращена гостю или станет оплатой новой брони на новые даты/номера.</p>  
			<p>Если Вы обратились с просьбой изменить/отменить бронь позже срока, установленного для бесплатного изменения брони (72 часа до времени заезда по брони), то бронь может быть изменена или отменена, но с удержанием штрафа в размере 20% от стоимости заказа.</p>
			<p>Обязательно сохраняйте квитанции или подтверждение брони!</p>
        </td>
    </tr>
</table>
<br><br>
<table border="1px" cellpadding="5">
    <tr>
        <td>
            Пожалуйста, сообщите заранее, если Вам нужен <b>СЧЕТ-ФАКТУРА</b>. В противном случае, мы не сможем предоставить его. 
        </td>
    </tr>
</table>
<p style="text-align: center; font-weight: bold;">Как оплатить бронь в любом банке с помощью банковского перевода?</p>
<p>Для оформления банковского перевода, Вам нужно указать реквизиты получателя <b>ТОО «Асфальтобетон 1»:</b></p>
<table border="1" cellpadding="5">
    <tr>
        <td style="width:50%">
            <b>ТОО «Асфальтобетон 1»</b><br>
            050014, г. Алматы, ул. Серикова 20а<br>
            БИН 060440009474
        </td>
        <td style="width:50%">
            ИИК KZ176010131000172106<br>
            АО Народный банк Казахстана<br>
            БИК HSBKKZKX<br>
			Код назначения платежа (КНП) – 869, КБЕ – 17  
        </td>
    </tr>
	<tr>
        <td style="width:50%">
            В платежном поручении обязательно  указать: 
        </td>
        <td style="width:50%">
            <b>Код брони</b> <?php echo $bill['id']; ?> <b><?php echo Arr::path($bill, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?></b> (ФИО того, кто будет отдыхать, если оплачивает кто-то другой),
        </td>
    </tr>
</table>
<p>Необходимо оформить именно «ПЛАТЕЖНОЕ ПОРУЧЕНИЕ», а не «ПОПОЛНЕНИЕ СЧЕТА». По завершении транзакции, банк предоставит Вам квитанцию об оплате или платежное поручение, которые Вы можете отправить нам по электронной почте <a href="info@karadala.kz">info@karadala.kz</a> или на номер WhatsApp +7 707 335 5717.</p>
<table border="1px"  cellpadding="5" style="font-weight: bold">
    <tr>
        <td>
            Вы получите сообщение-подтверждение на Вотсап или эл. почту сразу после зачисления денег на наш счет.  Спасибо за ваш выбор! 
        </td>
    </tr>
</table>