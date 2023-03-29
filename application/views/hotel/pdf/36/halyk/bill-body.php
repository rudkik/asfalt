<table>
    <tr>
        <td>Your Booking Info</td>
        <td style="text-align: right"><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['created_at']); ?></td>
    </tr>
</table>
<p style="text-align: center">Dear Guest!</p>
<p style="text-align: justify">Благодарим Вас за то, что Вы забронировали номер(а) на базе отдыха «Кара Дала»! Пожалуйста, в срок до <b><u><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['limit_time']); ?></u></b> оплатите Ваш заказ в размере от 20% до 100% его полной стоимости. Остаток суммы нужно будет оплатить перед заселением в номер. <b>В случае неуплаты в указанный срок, Ваша бронь будет отменена!</b></p>
<p style="text-align: center"><b>Your Booking Code:</b> <b style="font-size: 20px"><?php echo $bill['id']; ?></b></p>
<table style="font-weight: bold">
    <tr>
        <td style="width:20%">Guest:</td>
        <td style="width:80%"><?php echo Arr::path($bill, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Check-in Date:</td>
        <td style="width:80%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_from']); ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Check-out Date:</td>
        <td style="width:80%"><?php echo Helpers_DateTime::getDateFormatRus($bill['date_to']); ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Room(s):</td>
        <td style="width:80%"><?php echo $rooms; ?><br></td>
    </tr>
    <tr>
        <td style="width:20%">Total:</td>
        <td style="width:80%"><?php echo Func::getNumberStr($bill['amount'], TRUE, 0); ?> тенге<br></td>
    </tr>
    <tr>
        <td style="width:20%">To pay by <br><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($bill['limit_time']); ?>:</td>
        <td style="width:80%"><?php echo Func::getNumberStr($bill['amount'] - $bill['paid_amount'], TRUE, 0); ?> тенге<br></td>
    </tr>
</table>
<br><br>
<table border="1px" cellpadding="5">
    <tr>
        <td>
            By making a payment, you agree to Kara Dala Hot Springs Resort Rules, which are published at our web-site <a href="https://karadala.kz">www.karadala.kz</a>.
            <p>If you change/cancel your booking 72 hours before your check-in time and later, charges of 20% of the total sum will be applied. Otherwise, cancellation and changes could be made for free.</p>
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
<p style="text-align: center; font-weight: bold;">Как оплатить бронь в Народном банке?</p>
<p><b>1.	Оплата через кассу Народного банка:</b>	</p>
<ol>
    <li>В электронной очереди в отделении Народного банка выберите категорию «Платежи», затем «Прочие» и получите номерок для ожидания своей очереди.<br></li>
    <li>2)	Назовите кассиру «Получатель платежа» и его «Назначение», а также Ваш код брони (вместо «Номер договора»):<br><br>
        <table border="1" cellpadding="5">
            <tr>
                <td style="width:20%; font-weight: bold">Получатель платежа</td>
                <td style="width:80%">ТОО «Асфальтобетон»<br> уникальный идентификационный код <b>902 249</b></td>
            </tr>
            <tr>
                <td style="width:20%; font-weight: bold">Назначение платежа</td>
                <td style="width:80%">
                    (Пред)оплата согласно
                    <ul>
                        <li>кода брони №<b><?php echo $bill['id']; ?></b>,</li>
						<li><b>ФИО и номер телефона гостя, который будет отдыхать</b></li>
                    </ul>
                </td>
            </tr>
        </table>
    </li>
    <li>По завершении транзакции, кассир предоставит Вам квитанцию об оплате, которую Вы можете отправить по эл. почте <a href="info@karadala.kz">info@karadala.kz</a> или на номер WhatsApp +7 707 335 5717.</li>
</ol>
<p><b>2.2.	Оплата на сайте интернет-банкинга Народного банка:</b></p>
<p>В своем личном кабинете в меню «Переводы», выберите категорию «Перевод третьим лицам по номеру счета получателя» и следуйте инструкциям. Максимальная сумма перевода 500 тыс. тенге. Информация для осуществления перевода:</p>
<table border="1" cellpadding="5">
    <tr>
        <td style="width:30%">
            <b>Получатель платежа:</b> 
        </td>
        <td style="width:70%">
			<b>ТОО «Асфальтобетон 1»</b><br>050014, г. Алматы, ул. Серикова 20а<br>БИН 060440009474<br>ИИК KZ176010131000172106<br>АО Народный банк Казахстана<br>БИК HSBKKZKX<br>КБЕ – 17<br>Код назначения платежа (КНП) – 869
        </td>
    </tr>
	 <tr>
        <td style="width:30%">
            <b>Назначение платежа:</b> 
        </td>
        <td style="width:70%">
			(Пред)оплата за номер(а) согласно кода брони №<?php echo $bill['id']; ?>, ФИО и номер телефона гостя, который будет отдыхать
        </td>
    </tr>
</table>
<p>Пожалуйста, сохраните чек. Вы можете отправить его копию по эл. почте <a href="info@karadala.kz">info@karadala.kz</a> или на номер WhatsApp +7 707 335 5717.</p>
<p><b>2.3. Оплата через терминал Народного банка:</b></p>
<p>
В терминале выберите категорию «Оплата услуг», затем «Другие», выберите в списке «База отдыха «Кара Дала». Введите Ваш код брони в строке «Номер договора» и внесите наличные. Терминал сдачи не дает. Минимальный номинал принимаемых банкнот – 200 т	
</p>
<p>Пожалуйста, возьмите и сохраните чек! Вы можете отправить его копию по эл. почте <a href="info@karadala.kz">info@karadala.kz</a> или на номер WhatsApp +7 707 335 5717.</p>
<table border="1px"  cellpadding="5" style="font-weight: bold">
    <tr>
        <td>
            Вы получите сообщение-подтверждение на Ватсап или эл. почту сразу после зачисления денег на наш счет. Спасибо за ваш выбор! 
        </td>
    </tr>
</table>