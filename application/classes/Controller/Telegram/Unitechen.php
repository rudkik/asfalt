<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Telegram_UniTechEn extends Controller_Telegram
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response, Model_Language::LANGUAGE_ENGLISH);
    }

    public function action_registration()
    {
        $this->_sitePageData->url = '/telegram_en/registration';

        if($this->telegram->registrationBot($this->_sitePageData->urlBasic.'/telegram_en/index')){
            echo 'Bot registered "'.$this->_sitePageData->urlBasic.'/telegram_en/index".';
        }else{
            echo 'Bot NOT registered.';
        }
    }

    /**
     * Получение операторов по телеграм чату
     * @param $languageID
     * @param $rubric
     * @return array
     */
    public function getTelegramOperations($languageID, $rubric)
    {
        $shopTelegramUserIDs = Request_Request::find('DB_Shop_Telegram_User',
            $this->_sitePageData->shopID,
            $this->_sitePageData,
            $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'telegram_is_operation' => true,
                )
            ), 0, true
        );

        $model = new Model_Shop_Telegram_User();

        $result = [];
        foreach ($shopTelegramUserIDs->childs as $child){
            $child->setModel($model);
            $data = Arr::path($model->getOptionsArray(), 'manager_options', array());

            if(Arr::path($data, $languageID.'.'.$rubric, false)){
                $result[] = $model->getTelegramChatID();
            }
        }

        return $result;
    }

    /**
     * Получение пользователя по телеграм чату
     * @param $telegramChatID
     * @return Model_Shop_Telegram_User
     */
    public function getTelegramUser($telegramChatID)
    {
        $shopTelegramUserIDs = Request_Request::find('DB_Shop_Telegram_User',
            $this->_sitePageData->shopID,
            $this->_sitePageData,
            $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'telegram_chat_id' => $telegramChatID,
                )
            ), 1, true
        );

        $model = new Model_Shop_Telegram_User();
        $model->setDBDriver($this->_driverDB);

        if(count($shopTelegramUserIDs->childs) > 0){
            $shopTelegramUserIDs->childs[0]->setModel($model);
        }else {
            $model->setTelegramChatID($telegramChatID);
        }

        return $model;
    }

    /**
     * Задаем язык пользователю
     * @param $languageID
     * @param $telegramChatID
     * @param null $telegramCommand
     */
    public function setLanguageTelegramUser($languageID, $telegramChatID, $telegramCommand = null)
    {
        $model = $this->getTelegramUser($telegramChatID);
        $model->setTelegramLanguageID($languageID);
        $model->setTelegramLastCommand($telegramCommand);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);
    }

    /**
     * Список команд телеграм бота
     */
    protected function commands()
    {
        $bot = $this->telegram->getClient();
        $telegramController = $this;

        $bot->command('add_manager', function ($message) use ($bot, $telegramController) {
            $model = $telegramController->getTelegramUser($message->getChat()->getId());
            $model->setTelegramLastCommand('set_manager_rubric');
            Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

            $answer = 'For what requests do you want to receive applications from clients?'
                ."\r\n".'1. Slaughter houses and deboning rooms'
                ."\r\n".'2. Meat, fish and poultry processing (production of sausages)'
                ."\r\n".'3. Milling technologies'
                ."\r\n".'4. Pasta processing'
                ."\r\n".'5. Filling of beverage and liquid products'
                ."\r\n".'6. HORECA machines and consumables';

            $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("1", "2", "3", "4", "5", "6")), false, true);

            $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
        });

        $bot->command('del_manager', function ($message) use ($bot, $telegramController) {
            $model = $telegramController->getTelegramUser($message->getChat()->getId());
            $model->setTelegramLastCommand('del_manager_rubric');
            Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

            $data = Arr::path($model->getOptionsArray(), 'manager_options', array());

            $list = [];
            foreach ($data as $languageID => $rubrics){
                $language = '';
                switch ($languageID){
                    case Model_Language::LANGUAGE_RUSSIAN:
                        $language = 'Русский';
                        break;
                    case Model_Language::LANGUAGE_ENGLISH:
                        $language = 'English';
                        break;
                    default:
                        continue;
                }

                if(is_array($rubrics)){
                    foreach ($rubrics as $rubric => $one){
                        $list[] = print_r($rubric, true).' - '.$language;
                    }
                }
            }

            $answer = 'Какие запросы нужно удалить?';
            $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array($list), false, true);

            $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
        });

        // обязательное. Запуск бота
        $bot->command('start', function ($message) use ($bot, $telegramController) {
            $model = $telegramController->getTelegramUser($message->getChat()->getId());
            $model->setTelegramLastCommand('set_language');
            Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

            $answer = 'Hi! I am Uni-Tech Chatbot. After formilies I will try to connect you with consultant.'
                ."\r\n".'For conversation please press Start.';

            $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("Start")), false, true);

            $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
        });

        // помощ
        $bot->command('help', function ($message) use ($bot) {
            $answer = 'Команды:'."\r\n".'/help - помощь.';
            $bot->sendMessage($message->getChat()->getId(), $answer);
        });

        $bot->on(function($update) use ($bot, $telegramController){
            /** @var TelegramBot\Api\Types\Update $update */
            $message = $update->getMessage();

            $model = $this->getTelegramUser($message->getChat()->getId());
            $model->setTelegramLanguageID(Model_Language::LANGUAGE_ENGLISH);
            switch ($model->getTelegramLastCommand()){
                case 'del_manager_rubric':
                    $s = $message->getText();

                    if(mb_strpos($s, 'Russian') !== false){
                        $languageID = Model_Language::LANGUAGE_RUSSIAN;
                    }elseif(mb_strpos($s, 'English') !== false){
                        $languageID = Model_Language::LANGUAGE_ENGLISH;
                    }else{
                        $languageID = 0;
                    }
                    $s = str_replace('Russian', '', str_replace('English', '', str_replace(' ', '', str_replace('-', '', $s))));

                    $data = Arr::path($model->getOptionsArray(), 'manager_options', array());
                    unset($data[$languageID][$s]);

                    $model->addOptionsArray(
                        [
                            'manager_options' => $data
                        ]
                    );

                    $model->setTelegramLastCommand('del_manager_rubric');
                    Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                    $list = [];
                    foreach ($data as $languageID => $rubrics){
                        $language = '';
                        switch ($languageID){
                            case Model_Language::LANGUAGE_RUSSIAN:
                                $language = 'Russian';
                                break;
                            case Model_Language::LANGUAGE_ENGLISH:
                                $language = 'English';
                                break;
                            default:
                                continue;
                        }

                        if(is_array($rubrics)){
                            foreach ($rubrics as $rubric => $one){
                                $list[] = print_r($rubric, true).' - '.$language;
                            }
                        }
                    }

                    $answer = 'Какие запросы нужно удалить?';
                    $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array($list), false, true);

                    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);

                    break;

                case 'set_manager_rubric':
                    if($message->getText() == 'Exit'){
                        $answer = 'Exit';
                        $model->setTelegramLastCommand('finish');
                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardHide();
                    }else {
                        $model->setTelegramLastCommand('set_manager_language');

                        $data = Arr::path($model->getOptionsArray(), 'manager_options', array());
                        $data['set_manager_rubric'] = $message->getText();

                        $model->addOptionsArray(
                            [
                                'manager_options' => $data
                            ]
                        );

                        $answer = 'Choose your language';

                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("Russian", "English")), false, true);
                    }
                    Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
                    break;
                case 'set_manager_language':
                    switch ($message->getText()){
                        case 'Russian':
                            $languageID = Model_Language::LANGUAGE_RUSSIAN;
                            break;
                        case 'English':
                            $languageID = Model_Language::LANGUAGE_ENGLISH;
                            break;
                        default:
                            $languageID = 0;
                    }

                    if($languageID > 0) {
                        $model->setTelegramLastCommand('set_manager_rubric');
                        $data = Arr::path($model->getOptionsArray(), 'manager_options', array());
                        $data[$languageID][$data['set_manager_rubric']] = true;
                        unset($data['set_manager_rubric']);

                        $model->addOptionsArray(
                            [
                                'manager_options' => $data
                            ]
                        );
                        $model->setTelegramIsOperation(true);

                        $answer = 'You are successfully added.'
                            . "\r\n"
                            . "\r\n" . 'For what more requests do you want to receive applications from clients?'
                            . "\r\n" . '1. Slaughter houses and deboning rooms'
                            . "\r\n" . '2. Meat, fish and poultry processing (production of sausages)'
                            . "\r\n" . '3. Milling technologies'
                            . "\r\n" . '4. Pasta processing'
                            . "\r\n" . '5. Filling of beverage and liquid products'
                            . "\r\n" . '6. HORECA machines and consumables';

                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("1", "2", "3", "4", "5", "6", 'Exit')), false, true);
                    }else{
                        $answer = 'Exit';
                        $model->setTelegramLastCommand('finish');
                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardHide();
                    }
                    Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
                    break;

                case 'set_language':
                    $languageID = Model_Language::LANGUAGE_ENGLISH;

                    if($languageID > 0){
                        $model->setTelegramLanguageID($languageID);

                        $model->setName($message->getText());
                        $model->setTelegramLastCommand('set_name');
                        Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                        switch ($model->getTelegramLanguageID()){
                            case Model_Language::LANGUAGE_RUSSIAN:
                                $answer = 'Как я могу к Вам обращаться?';
                                break;
                            default:
                                $answer = 'What is your name?';
                        }

                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardHide();
                    }else{
                        $answer = 'Выберите язык'
                            ."\r\n".'Choose your language';

                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("Русский", "English")), false, true);
                    }

                    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);

                    break;
                case 'set_name':
                    $model->setName($message->getText());
                    $model->setTelegramLastCommand('set_phone');
                    Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                    switch ($model->getTelegramLanguageID()){
                        case Model_Language::LANGUAGE_RUSSIAN:
                            $answer = 'Укажите номер вашего телефона';
                            break;
                        default:
                            $answer = 'What is your telephone number?';
                    }

                    $bot->sendMessage($message->getChat()->getId(), $answer);
                    break;
                case 'set_phone':
                    $regexp = '/^\s?(\+\s?[0-9])([- ()]*\d){10,11}$/';
                    if (preg_match($regexp, $message->getText())) {
                        $model->addOptionsArray(
                            [
                                'phone' => $message->getText()
                            ]
                        );
                        $model->setTelegramLastCommand('set_email');
                        Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                        switch ($model->getTelegramLanguageID()) {
                            case Model_Language::LANGUAGE_RUSSIAN:
                                $answer = 'Введите электронную почту (e-mail)';
                                break;
                            default:
                                $answer = 'What is your e-mail address?';
                        }
                    }else{
                        switch ($model->getTelegramLanguageID()){
                            case Model_Language::LANGUAGE_RUSSIAN:
                                $answer = 'Укажите номер вашего телефона';
                                break;
                            default:
                                $answer = 'What is your telephone number?';
                        }
                    }
                    $bot->sendMessage($message->getChat()->getId(), $answer);
                    break;
                case 'set_email':
                    if (filter_var($message->getText(), FILTER_VALIDATE_EMAIL) !== false){
                        $model->addOptionsArray(
                            [
                                'email' => $message->getText()
                            ]
                        );
                        $model->setTelegramLastCommand('set_question');
                        Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                        switch ($model->getTelegramLanguageID()){
                            case Model_Language::LANGUAGE_RUSSIAN:
                                $answer = 'По какому вопросу Вам необходима консультация?'
                                    ."\r\n".'1. Технологии убоя скота'
                                    ."\r\n".'2. Переработка рыбы, птицы, мяса (производство колбасных изделий)'
                                    ."\r\n".'3. Переработка зерна и производство муки'
                                    ."\r\n".'4. Производство макаронных изделий'
                                    ."\r\n".'5. Розлив всех видов жидкости'
                                    ."\r\n".'6. Ритейл оборудование и расходные материалы для ресторанов, супермаркетов';
                                break;
                            default:
                                $answer = 'What is your topic of interest?'
                                    ."\r\n".'1. Slaughter houses and deboning rooms'
                                    ."\r\n".'2. Meat, fish and poultry processing (production of sausages)'
                                    ."\r\n".'3. Milling technologies'
                                    ."\r\n".'4. Pasta processing'
                                    ."\r\n".'5. Filling of beverage and liquid products'
                                    ."\r\n".'6. HORECA machines and consumables';
                        }

                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("1", "2", "3", "4", "5", "6")), false, true);
                    }else{
                        $model->addOptionsArray(
                            [
                                'phone' => $message->getText()
                            ]
                        );
                        $model->setTelegramLastCommand('set_email');
                        Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);

                        switch ($model->getTelegramLanguageID()) {
                            case Model_Language::LANGUAGE_RUSSIAN:
                                $answer = 'Введите электронную почту (e-mail)';
                                break;
                            default:
                                $answer = 'What is your e-mail address?';
                        }
                        $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardHide();
                    }
                    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
                    break;
                case 'set_question':
                    switch ($model->getTelegramLanguageID()){
                        case Model_Language::LANGUAGE_RUSSIAN:
                            switch ($message->getText()){
                                case '1':
                                    $s = 'Технологии убоя скота';
                                    break;
                                case '2':
                                    $s = 'Переработка рыбы, птицы, мяса (производство колбасных изделий)';
                                    break;
                                case '3':
                                    $s = 'Переработка зерна и производство муки';
                                    break;
                                case '4':
                                    $s = 'Производство макаронных изделий';
                                    break;
                                case '5':
                                    $s = 'Розлив всех видов жидкости';
                                    break;
                                case '6':
                                    $s = 'Ритейл оборудование и расходные материалы для ресторанов, супермаркетов';
                                    break;
                                default:
                                    $s = $message->getText();
                            }
                            break;
                        default:
                            switch ($message->getText()){
                                case '1':
                                    $s = 'Slaughter houses and deboning rooms';
                                    break;
                                case '2':
                                    $s = 'Meat, fish and poultry processing (production of sausages)';
                                    break;
                                case '3':
                                    $s = 'Milling technologies';
                                    break;
                                case '4':
                                    $s = 'Pasta processing';
                                    break;
                                case '5':
                                    $s = 'Filling of beverage and liquid products';
                                    break;
                                case '6':
                                    $s = 'HORECA machines and consumables';
                                    break;
                                default:
                                    $s = $message->getText();
                            }
                    }

                    $model->addOptionsArray(
                        [
                            'question' => $s,
                        ]
                    );
                    $model->setTelegramLastCommand('set_language');
                    Helpers_DB::saveDBObject($model, $telegramController->_sitePageData);


                    // отправляем заявку оператору
                    $operations = $telegramController->getTelegramOperations(
                        $model->getTelegramLanguageID(),
                        $message->getText() * 1
                    );

                    $text = 'Имя/Name: '.$model->getName()
                        ."\r\nТелефон/Phone: " . Arr::path($model->getOptionsArray(), 'phone', array())
                        ."\r\nE-mail: " . Arr::path($model->getOptionsArray(), 'email', array())
                        ."\r\n" . Arr::path($model->getOptionsArray(), 'question', array());

                    foreach ($operations as $operation){
                        $bot->sendMessage($operation, $text);
                    }

                    if(Mail::sendEMailHTML($this->_sitePageData, '', 'New request telegram', str_replace("\r\n", '<br>'."\r\n", $text))){

                    }

                    switch ($model->getTelegramLanguageID()){
                        case Model_Language::LANGUAGE_RUSSIAN:
                            $answer = 'Спасибо за обращение!'
                                ."\r\n".'Ваша заявка принята ожидайте ответа или звонка от сотрудника.';
                            break;
                        default:
                            $answer = 'Thank you for your request!'
                                ."\r\n".'Please wait for our answer or call from our employee.';
                    }

                    $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup(array(array("New request")), false, true);

                    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
                    break;
            }
        }, function($message){
            return true; // когда тут true - команда проходит
        });

        $bot->run();
    }
}