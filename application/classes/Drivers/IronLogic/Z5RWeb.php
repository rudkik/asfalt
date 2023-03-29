<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Контроллер соединяется с сервером по протоколу HTTP(s)и методом POST отправляетимеющиеся у него данные.
 * Сервер в ответ на запросприсылает управляющие сообщения дляк онтроллера.
 * Размер пакета отправляемого контроллеруне должен превышать 2 кБ
 * Если сервер поддерживает ONLINE проверку доступа,то при поднесении карты делается запросна сервер для проверки разрешения на проход.
 * При этомвсе остальные функции (события, запись картитд) работают.
 * При невозможности ONLINE проверки контроллер (сервернедоступен или возвращает ошибку) переходит в OFFLINE режим и работает с картами, записаннымив его память.
 * Периодически контроллер проверяет доступность сервера1.
 * Class Drivers_IronLogic_Z5RWeb
 */
class Drivers_IronLogic_Z5RWeb {
    const INTERVAL = 8;
    const CACHE_NAME = 'Z5RWeb';

    /**
     * Сохраняем сообщения от контролера
     * @param $name
     * @param array $message
     * @param Model_Ab1_Shop_Worker_Passage $modelPassage
     * @param SitePageData $sitePageData
     * @return bool|int
     */
    private static function _saveMessage($name, array $message, Model_Ab1_Shop_Worker_Passage $modelPassage,
                                         SitePageData $sitePageData){
        $number = Arr::path($message, 'id');
        if(empty($number)){
            return false;
        }

        $model = new Model_Ab1_Shop_Worker_Passage_Message();
        $model->setDBDriver($modelPassage->getDBDriver());
        $model->setName($name);
        $model->setOptionsArray($message);
        $model->setMessageNumber($number);
        $model->setShopWorkerPassageID($modelPassage->id);

        return Helpers_DB::saveDBObject($model, $sitePageData, $modelPassage->shopID);
    }

    /**
     * Получить ключ Memcache
     * @param $key
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @return string
     */
    private static function _getKeyCache($key, Model_Ab1_Shop_Worker_Passage $model){
        return self::CACHE_NAME . '_' . $model->id . '_' . $key;
    }

    /**
     * Получить значение из Memcache
     * @param $cache
     * @param $key
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @param null $default
     * @return mixed
     */
    private static function _getCache($cache, $key, Model_Ab1_Shop_Worker_Passage $model, $default = NULL){
        return $cache->get(self::_getKeyCache($key, $model), $default);
    }

    /**
     * Созранить значение в Memcache
     * @param $cache
     * @param $key
     * @param $value
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @return mixed
     */
    private static function _setCache($cache, $key, $value, Model_Ab1_Shop_Worker_Passage $model){
        $cache->set(self::_getKeyCache($key, $model), $value);
    }

    /**
     * Отправляем сообщения контролеру в ответ
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @return array
     */
    private static function _sendMessages(Model_Ab1_Shop_Worker_Passage $model){
        $messages = [];
        $messages['date'] = date('Y-m-d H:i:s');
        $messages['interval'] = self::INTERVAL;
        $messages['messages'] = [];

        $cache = Cache::instance('memcache');

        $from = self::_getCache($cache, 'from', $model, 0);
        $to = self::_getCache($cache, 'to', $model, 0);

        if($from + 10 < $to){
            $to = $from + 10;
        }
        self::_setCache($cache, 'from', $to, $model);

        for ($i = $from; $i < $to; $i++){
            $message = self::_getCache($cache, 'command.' . $i, $model, null);
            if(!is_array($message)){
                continue;
            }

            $messages['messages'][] = $message;
        }

       return $messages;
    }

    /**
     * Отправляем сообщения контролеру в ответ пустое сообщение
     * @return array
     */
    private static function _sendEmptyMessages(){
        $messages = [];
        $messages['date'] = date('Y-m-d H:i:s');
        $messages['interval'] = self::INTERVAL;
        $messages['messages'] = [];

        return $messages;
    }

    /**
     * Добавляем команду в очередь на отправку
     * @param $name
     * @param array $message
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @param bool $isRequest
     * @param bool $isFirst
     */
    private static function _addMessage($name, array $message, Model_Ab1_Shop_Worker_Passage $model,
                                        $isRequest = false, $isFirst = false){
        $cache = Cache::instance('memcache');

        if($isFirst){
            $index = self::_getCache($cache, 'from', $model, null);
            if($index === null){
                $index = 0;
                self::_setCache($cache, 'to', $index + 1, $model);
            }else{
                $index--;
                self::_setCache($cache, 'from', $index, $model);
            }
        }else {
            $index = self::_getCache($cache, 'to', $model, 0);
            self::_setCache($cache, 'to', $index + 1, $model);
        }

        $message1 = [];
        if(!empty($name)) {
            $id = self::_getCache($cache, 'id', $model, 1);
            self::_setCache($cache, 'id', $id + 1, $model);

            $message1['id'] = $id + 6000;
            $message1['operation'] = $name;
        }

        $message = array_merge($message1, $message);

        self::_setCache($cache, 'command.' . $index, $message, $model);
    }

    /**
     * SET_ACTIVE Активирует / деактивирует работу контроллера с сервером.
     * Неактивированный контроллер непередаёт события и не принимает управляющие посылки.
     * Также сервер сообщает контроллеру, поддерживает лион ONLINE проверку доступа
     * Запрос: {"id":123456789,"operation":"set_active","active":1,"online":1}
     * active: 1 - активация контроллера, 0 - дезактивация
     * online: 1 - сервер поддерживает режим ONLINE, 0 - не поддерживает
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function setActive(Model_Ab1_Shop_Worker_Passage $model){
        $message = [];
        $message['active'] = 1;
        $message['online'] = 1;
        $message['open'] = null;

        self::_addMessage('set_active', $message, $model, true);
    }

    /**
     * Вызывает срабатывание выходного каскада в заданномнаправлении
     * Запрос:{"id":123456789,"operation":"open_door","direction": 0}
     * direction - 0 - вход, 1 - выход
     * @param $isExit
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function openDoor($isExit, Model_Ab1_Shop_Worker_Passage $model){
        $message = [];
        $message['direction'] = Func::boolToInt($isExit);

        self::_addMessage('open_door', $message, $model, true, true);
    }

    const MODE_TYPE_NORM = 0; // норма
    const MODE_TYPE_BLOCK = 1; // блок
    const MODE_TYPE_FREE = 2; // свободный проход
    const MODE_TYPE_WAIT_FREE = 3; // ожидание свободного прохода

    /**
     * Устанавливает режим работы контроллера
     * (Норма, Свободный проход, Блокировка, Ожидание Свободного прохода)
     * Запрос: {"id":123456789,"operation":"set_mode","mode": 2}
     * возможные режимы: 0 - норма, 1 - блок, 2 - свободный проход, 3 - ожидание свободного прохода
     * @param $mode
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function setMode($mode, Model_Ab1_Shop_Worker_Passage $model){
        $message = [];
        $message['mode'] = $mode;

        self::_addMessage('set_mode', $message, $model, true);
    }

    /**
     * Устанавливает параметры временной зоны контроллера
     * Запрос:{"id":123456789,"operation":"set_timezone","zone": 0,"begin":"00:00","end":"23:59","days":"11111110"}
     * zone - номер временной зоны (0 - 6)
     * begin - время начала действия зоны
     * end - время окончания действия зоны
     * days - маска дней недели для зоны (0 - зона выключена,1 -включена), понедельник - 1-й
     * @param $zoneNumber
     * @param $timeFrom
     * @param $timeTo
     * @param $isMonday
     * @param $isTuesday
     * @param $isWednesday
     * @param $isThursday
     * @param $isFriday
     * @param $isSaturday
     * @param $isSunday
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function setTimezone($zoneNumber, $timeFrom, $timeTo,
                                       $isMonday, $isTuesday, $isWednesday, $isThursday, $isFriday, $isSaturday, $isSunday,
                                       Model_Ab1_Shop_Worker_Passage $model){
        $message = [];
        $message['zone'] = $zoneNumber;
        $message['begin'] = Helpers_DateTime::getTimeFormatRus($timeFrom);
        $message['end'] = Helpers_DateTime::getTimeFormatRus($timeTo);
        $message['days'] = Func::boolToInt($isMonday)
            . Func::boolToInt($isTuesday)
            . Func::boolToInt($isWednesday)
            . Func::boolToInt($isThursday)
            . Func::boolToInt($isFriday)
            . Func::boolToInt($isSaturday)
            . Func::boolToInt($isSunday);

        self::_addMessage('set_timezone', $message, $model, true);
    }

    /**
     * Устанавливает параметры открывания и контроля состояниядвери
     * Запрос:{"id":123456789,"operation":"set_door_params","open":30,"open_control":50,"close_control":50}
     * open - время подачи сигнала открывания замка (в 1/10секунды)
     * open_control - время контроля открытия двери (в 1/10секунды)
     * close_control - время контроля закрытия двери (в 1/10секунды)
     * @param int $openSecond
     * @param int $waitSecond
     * @param int $closeSecond
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function setDoorParams(int $openSecond, int $waitSecond, int $closeSecond, Model_Ab1_Shop_Worker_Passage $model){
        if($openSecond < 1){
            $openSecond = 1;
        }
        if($openSecond > 10){
            $openSecond = 10;
        }

        if($waitSecond < 1){
            $waitSecond = 1;
        }
        if($waitSecond > 10){
            $waitSecond = 10;
        }

        if($closeSecond < 1){
            $closeSecond = 1;
        }
        if($closeSecond > 10){
            $closeSecond = 10;
        }

        $message = [];
        $message['open'] = $openSecond;
        $message['open_control'] = $waitSecond;
        $message['close_control'] = $closeSecond;

        self::_addMessage('set_door_params', $message, $model, true);
    }

    const CARD_FLAG_BASIC = 0;
    const CARD_FLAG_BLOCK = 8; // блокирующая карта
    const CARD_FLAG_SHORT_NUMBER = 32; // короткий код карты (три байта)

    /**
     * Добавляет карты в память контроллера.
     * Если в памятиконтроллера уже имеется карта с таким-женомером, для этой карты обновляются флаги  и временные зоны.
     * Запрос:{"id":123456789,"operation":"add_cards","cards": [
     * {"card": "00B5009EC1A8","flags": 0, "tz": 255},
     * {"card": "0000000FE32A2","flags": 32,"tz": 255}
     * ]}
     * cards - массив карт для добавления
     * card - номер карты в шестнадцатеричном виде (см. ПРИЛОЖЕНИЕ2)
     * flags - флаги для  карты (8 - блокирующая карта, 32- короткий код карты (три байта))
     * tz - временные зоны для карты
     * @param $number
     * @param $flag
     * @param $zoneNumber
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function addCard($number, $flag, $zoneNumber, Model_Ab1_Shop_Worker_Passage $model){
        $message = [];
        $message['cards'][] = [
            'card' => $number,
            'flags' => $flag,
            'tz' => $zoneNumber,
        ];

        self::_addMessage('add_cards', $message, $model, true);
    }

    /**
     * Удаляет карты из памяти контроллера
     * Запрос:{"id":123456789,"operation":"del_cards","cards": [
     * {"card":"000000A2BA93"},
     * {"card":"000000A2A18A"}
     * ]}
     * cards - массив карт для удаления, содержит номеракарты в шестнадцатеричном виде (см.ПРИЛОЖЕНИЕ 2)
     * @param array | string $cards
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function delCards($cards, Model_Ab1_Shop_Worker_Passage $model){
        if(!is_array($cards)){
            $cards = [$cards];
        }

        $message = [];
        $message['cards'] = [];

        foreach ($cards as $card){
            $message['cards'][] = [
                'card' => $card,
            ];
        }

        self::_addMessage('del_cards', $message, $model, true);
    }

    /**
     * Удаляет все карты из памяти контроллера
     * Запрос:{"id":123456789,"operation":"clear_cards"}
     * @param Model_Ab1_Shop_Worker_Passage $model
     */
    public static function clearCards(Model_Ab1_Shop_Worker_Passage $model){
        self::_addMessage('clear_cards', [], $model, true);
    }

    /**
     * Посылается при первом соединении после питания контроллераи продолжает посылаться до тех пор,пока сервер не пришлет SET_ACTIVE
     * {"id": 123456789, "operation": "power_on", "fw": "1.0.1", "conn_fw": "2.0.2","active": 0, "mode": 0, "controller_ip": "192.168.0.222"}
     * operation - название операции
     * fw - версия прошивки контроллера
     * conn_fw - версия прошивки модуля связи
     * active - признак активированности контроллера
     * mode - режим работы контроллера(смотри SET_MODE)
     * controller_ip - IP адрес контроллера в локальной сети
     * @param array $message
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @param SitePageData $sitePageData
     * @param bool $isSendMessage
     * @return array | boolean
     */
    public static function powerOn(array $message, Model_Ab1_Shop_Worker_Passage $model, SitePageData $sitePageData,
                                   $isSendMessage = false){
        self::_saveMessage('power_on', $message, $model, $sitePageData);

        $model->setIP(Arr::path($message, 'controller_ip', $model->getIP()));
        $model->setOptionsValue('z5rweb', $message);

        // Активизируем работу контролера с сервером
        self::setActive($model);

        if($isSendMessage) {
            return self::_sendMessages($model);
        }

        return true;
    }

    /**
     *
     * @param $card
     * @return string
     */
    private static function _cardHexToNumber($card){
        return hexdec($card);
    }

    /**
     * Посылается контроллером в режиме ONLINE проверки доступа при поднесении карты к считывателю
     * Запрос:{"id": 123456789,"operation": "check_access","card": "00B5009EC1A8","reader": 1}
     * card - номер карты в шестнадцатеричном виде (см. ПРИЛОЖЕНИЕ2)
     * reader - считыватель, к которому приложена карта.1- вход, 2 - выход.
     * Ответ:{"id":123456789,"operation": "check_access","granted":1}
     * granted - 1 - проход разрешен, 0 - запрещен
     * @param array $message
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @param SitePageData $sitePageData
     * @param bool $isSendMessage
     * @return boolean | array
     */
    public static function checkAccess(array $message, Model_Ab1_Shop_Worker_Passage $model, SitePageData $sitePageData,
                                       $isSendMessage = false){
        $messageID = self::_saveMessage('check_access', $message, $model, $sitePageData);

        $driver = $model->getDBDriver();

        $isEntry = Arr::path($message, 'reader') == 1;

        $card = Arr::path($message, 'card');
        if(!empty($card)){
            // решаем глюк считывателя, посылает много данных после номера карточки
            if(strlen($card) > 12){
                $card = substr($card, 0, 12);
            }

            $card = self::_cardHexToNumber($card);
        }

        $isGranted = !empty($card);

        $modelLog = new Model_Ab1_Shop_Worker_EntryExit_Log();
        $modelLog->setDBDriver($driver);

        $modelLog->setName($card);
        $modelLog->setShopWorkerPassageMessageID($messageID);
        $modelLog->setShopWorkerPassageID($model->id);
        if($isEntry) {
            $modelLog->setDateEntry(date('Y-m-d H:i:s'));
        }else{
            $modelLog->setDateExit(date('Y-m-d H:i:s'));

        }

        if($isGranted){
            /** @var Model_Magazine_Shop_Card $modelCard */
            $cardData = Request_Request::findOne(
                DB_Magazine_Shop_Card::NAME, 0, $sitePageData, $driver,
                Request_RequestParams::setParams(['number_full' => $card]),
                ['shop_worker_id' => ['shop_department_id']]
            );

            $isGranted = !empty($cardData);

            if($isGranted){
                $modelCard = new Model_Magazine_Shop_Card();
                $cardData->setModel($modelCard);

                $modelLog->setShopWorkerID($modelCard->getShopWorkerID());
                $modelLog->setShopCardID($modelCard->id);

                if(!$model->getIsInsideMove()) {
                    /** @var Model_Ab1_Shop_Worker_EntryExit $modelEntryExit */
                    $modelEntryExit = Request_Request::findOneModel(
                        DB_Ab1_Shop_Worker_EntryExit::NAME, $model->shopID, $sitePageData, $driver,
                        Request_RequestParams::setParams(
                            [
                                'is_exit' => false,
                                'shop_card_id' => $modelCard->id,
                                'shop_worker_passage_id.is_exit' => true,
                                'sort_by' => [
                                    'created_at' => 'desc',
                                ],
                            ]
                        )
                    );
                }else{
                    $modelEntryExit = null;
                }

                if($isEntry) {
                    if($modelEntryExit == null || strtotime($modelEntryExit->getDateEntry() . ' +5 minutes') < time()){
                        $modelEntryExit = new Model_Ab1_Shop_Worker_EntryExit();
                        $modelEntryExit->setDBDriver($driver);

                        $modelEntryExit->setIsInsideMove($model->getIsInsideMove());
                        $modelEntryExit->setDateEntry(date('Y-m-d H:i:s'));
                        $modelEntryExit->setShopWorkerPassageID($model->id);
                        $modelEntryExit->setIsCar($model->getIsCar());
                        $modelEntryExit->setShopWorkerID($modelCard->getShopWorkerID());
                        $modelEntryExit->setShopCardID($modelCard->id);
                        $modelEntryExit->setShopDepartmentID(
                            $cardData->getElementValue('shop_worker_id', 'shop_department_id', 0)
                        );

                        if(!$model->getIsInsideMove()) {
                            // TODO Доделать просчет времени опоздания на работу (хуй)
                        }

                        Helpers_DB::saveDBObject($modelEntryExit, $sitePageData, $model->shopID);

                        $modelLog->setShopWorkerEntryExitID($modelEntryExit->id);
                    }
                }else{
                    if($model->getIsInsideMove()) {
                        $modelEntryExit = new Model_Ab1_Shop_Worker_EntryExit();
                        $modelEntryExit->setDBDriver($driver);

                        $modelEntryExit->setIsInsideMove($model->getIsInsideMove());
                        $modelEntryExit->setShopWorkerPassageID($model->id);
                        $modelEntryExit->setIsCar($model->getIsCar());
                        $modelEntryExit->setShopWorkerID($modelCard->getShopWorkerID());
                        $modelEntryExit->setShopCardID($modelCard->id);
                        $modelEntryExit->setShopDepartmentID(
                            $cardData->getElementValue('shop_worker_id', 'shop_department_id', 0)
                        );
                    }
                    if($modelEntryExit != null) {
                        $modelEntryExit->setExitShopWorkerPassageID($model->id);
                        $modelEntryExit->setDateExit(date('Y-m-d H:i:s'));

                        if (!$model->getIsInsideMove()) {
                            // TODO Доделать просчет времени выхода с работы раньше (хуй)
                        }

                        Helpers_DB::saveDBObject($modelEntryExit, $sitePageData, $model->shopID);

                        $modelLog->setShopWorkerEntryExitID($modelEntryExit->id);
                    }
                }
            }
        }

        Helpers_DB::saveDBObject($modelLog, $sitePageData, $model->shopID);

        // посылаем открыть дверь
        if($isGranted) {
            self::openDoor(!$isEntry, $model);
        }

        $message = [];
        $message['granted'] = Func::boolToInt($isGranted);
        self::_addMessage('check_access', $message, $model, true, true);

        if($isSendMessage) {
            return self::_sendMessages($model);
        }

        return $isGranted;
    }

    /**
     * Посылается периодически при отсутствии событий. Интервалпередачи настраивается в WEB-интерфейсе.
     * {"id": 123456789,"operation": "ping","active": 1,"mode": 0}
     * @param array $message
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @param SitePageData $sitePageData
     * @param bool $isSendMessage
     * @return array | boolean
     */
    public static function ping(array $message, Model_Ab1_Shop_Worker_Passage $model, SitePageData $sitePageData,
                                $isSendMessage = false){
        //self::_saveMessage('ping', $message, $model, $sitePageData);

        if($isSendMessage) {
            return self::_sendEmptyMessages();
        }

        return true;
    }


    const EVENT_TYPE_ENTRY_OPEN = 0; // открыто кнопкой изнутри (вход)
    const EVENT_TYPE_EXIT_OPEN = 1; // открыто кнопкой изнутри (выход)

    const EVENT_TYPE_ENTRY_NOT_CARD = 2; // ключ не найден в банке ключей (вход)
    const EVENT_TYPE_EXIT_NOT_CARD = 3; // ключ не найден в банке ключей (выход)

    const EVENT_TYPE_ENTRY_FIND_CARD = 4; // ключ найден, дверь открыта (вход)
    const EVENT_TYPE_EXIT_FIND_CARD = 5; // ключ найден, дверь открыта (выход)

    const EVENT_TYPE_ENTRY_NOT_ALLOWED  = 6; // ключ найден, доступ не разрешен (вход)
    const EVENT_TYPE_EXIT_NOT_ALLOWED = 7; // ключ найден, доступ не разрешен (выход)

    const EVENT_TYPE_ENTRY_OPEN_OPERATION = 8; // Открыто оператором по сети (вход)
    const EVENT_TYPE_EXIT_OPEN_OPERATION = 9; // Открыто оператором по сети (выход)

    const EVENT_TYPE_ENTRY_BLOCK_DOOR = 10; // ключ найден, дверь заблокирована (вход)
    const EVENT_TYPE_EXIT_BLOCK_DOOR = 11; // ключ найден, дверь заблокирована (выход)

    const EVENT_TYPE_ENTRY_HACKED = 12; // дверь взломана (вход)
    const EVENT_TYPE_EXIT_HACKED = 13; // дверь взломана (выход)

    const EVENT_TYPE_ENTRY_LEFT_OPEN_DOOR = 14; // дверь оставлена открытой (timeout) (вход)
    const EVENT_TYPE_EXIT_LEFT_OPEN_DOOR = 15; // дверь оставлена открытой (timeout) (выход)

    const EVENT_TYPE_ENTRY_MAN_PASSED  = 16; // Проход состоялся (вход)
    const EVENT_TYPE_EXIT_MAN_PASSED  = 17; // Проход состоялся (выход)

    const EVENT_TYPE_RESTART = 20; // Перезагрузка контроллера

    const EVENT_TYPE_POWER = 21; // Питание flag: 0 – пропало 1 – появилось

    const EVENT_TYPE_ENTRY_OPEN_DOOR = 32; // Дверь открыта (вход)
    const EVENT_TYPE_EXIT_OPEN_DOOR = 33; // Дверь открыта (выход)

    const EVENT_TYPE_ENTRY_CLOSE_DOOR = 34; // Дверь закрыта (вход)
    const EVENT_TYPE_EXIT_CLOSE_DOOR = 35; // Дверь закрыта (выход)

    const EVENT_TYPE_FLAG = 37; // Переключение режимов работы (cм Режим) flag: Флаги Режимов
    const EVENT_TYPE_FIRE = 38; // Пожарные события (cм Пожар) flag: Флаги Пожара
    const EVENT_TYPE_SECURITY = 39; // Охранные события (cм Охрана) flag: Флаги Охраны

    const EVENT_TYPE_ENTRY_LATE_ACCESS  = 40; // Проход не совершен за заданное время (вход)
    const EVENT_TYPE_EXIT_LATE_ACCESS  = 41; // Проход не совершен за заданное время (выход)

    const EVENT_TYPE_ENTRY_GATEWAY = 48; // Совершен вход в шлюз (вход)
    const EVENT_TYPE_EXIT_GATEWAY = 49; // Совершен вход в шлюз (выход)

    const EVENT_TYPE_ENTRY_BLOCK_GATEWAY = 50; // Заблокирован вход в шлюз (занят) (вход)
    const EVENT_TYPE_EXIT_BLOCK_GATEWAY = 51; // Заблокирован вход в шлюз (занят) (выход)

    const EVENT_TYPE_ENTRY_ALLOWED_GATEWAY = 52; // Разрешен вход в шлюз (вход)
    const EVENT_TYPE_EXIT_ALLOWED_GATEWAY = 53; // Разрешен вход в шлюз (выход)

    const EVENT_TYPE_ENTRY_BLOCK_ANTIPASSBEK = 54; // Заблокирован проход (Антипассбек) (вход)
    const EVENT_TYPE_EXIT_BLOCK_ANTIPASSBEK = 55; // Заблокирован проход (Антипассбек) (выход)

    /**
     * Посылается при появлении новых событий в контроллере.
     * При ответе “success” = N, N событий считаются обработанными.
     * При ответе“success” = 0 или отсутствии ответа, повторяется отправка.
     * Запрос:{"id": 123456789, "operation": "events","events": [
     * {"event": 4,"card": "00B5009EC1A8","time": "2015-06-25 16:36:01","flag": 0},
     * {"event": 16,"card": "00BA00FE32A2","time": "2015-06-25 16:36:02","flag": 0}
     * ]}
     * events - массив событий
     * event - тип события (смотри ПРИЛОЖЕНИЕ 1)
     * card - номер карты в шестнадцатеричном виде (для событийс картой) (см. ПРИЛОЖЕНИЕ 2)
     * time - время события
     * flag - флаги события (для событий с флагами)
     * @param array $message
     * @param Model_Ab1_Shop_Worker_Passage $model
     * @param SitePageData $sitePageData
     * @param bool $isSendMessage
     * @return array | boolean
     */
    public static function events(array $message, Model_Ab1_Shop_Worker_Passage $model, SitePageData $sitePageData,
                                  $isSendMessage = false){
        //self::_saveMessage('events', $message, $model, $sitePageData);

        $events = Arr::path($message, 'events');
        if(!is_array($events)){
            $events = [];
        }

        $message = [];
        $message['events_success'] = count($events);
        self::_addMessage('events', $message, $model, true, true);

        if($isSendMessage) {
            return self::_sendMessages($model);
        }

        return true;
    }

    /**
     * Сообщения отправляемые контроллером
     * Все посылки имеют следующий вид:{"type": "Z5RWEB","sn": 50001,"messages": [
     * {"id": 10,...},
     * {"id": 20,...},
     * ...
     * {"id": N,...}
     * ]}
     * type - тип контроллера
     * sn - серийный номер контроллера
     * messages - массив сообщений от контроллера
     * id - уникальный идентификатор сообщения
     * @param array $message
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool | array
     * @throws HTTP_Exception_500
     */
    public static function requestMessage(array $message, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $number = Arr::path($message, 'sn');
        if(empty($number)){
            throw new HTTP_Exception_500('Serial number controller empty.');
        }

        /** @var Model_Ab1_Shop_Worker_Passage $model */
        $model = Request_Request::findOneModel(
            DB_Ab1_Shop_Worker_Passage::NAME, 0, $sitePageData, $driver,
            Request_RequestParams::setParams(['old_id_full' => $number])
        );
        if(empty($model)){
            $controller = Request_RequestParams::getParamStr('controller_id');
            if(!empty($controller)) {
                $model = Request_Request::findOneModel(
                    DB_Ab1_Shop_Worker_Passage::NAME, 0, $sitePageData, $driver,
                    Request_RequestParams::setParams(['controller_number_full' => $controller])
                );
                if(!empty($model)) {
                    $model->setOldID($number);
                }
            }

            if(empty($model)) {
                throw new HTTP_Exception_500('Controller serial number "' . $number . '" not found.');
            }
        }elseif(Func::_empty($model->getControllerNumber())) {
            $controller = Request_RequestParams::getParamStr('controller_id');
            if(!empty($controller)) {
                $model->setControllerNumber($controller);
            }
        }

        self::_saveMessage('messages', $message, $model, $sitePageData);

        $messages = Arr::path($message, 'messages');
        if(!is_array($messages)) {
            return false;
        }

        $isEmptyMessage = false;
        $isNecessarilyMessage = false;
        foreach ($messages as $message) {
            $operation = Arr::path($message, 'operation');
            $model->setLastOperation($operation);
            switch ($operation){
                case 'power_on':
                    self::powerOn($message, $model, $sitePageData);
                    break;
                case 'ping':
                    self::ping($message, $model, $sitePageData);
                    $isEmptyMessage = true;
                    break;
                case 'check_access':
                    self::checkAccess($message, $model, $sitePageData);
                    $isNecessarilyMessage = true;
                    break;
                case 'events':
                    self::events($message, $model, $sitePageData);
                    break;
                default:
                    $isEmptyMessage = true;
            }
        }

        $model->setDateConnect(date('Y-m-d H:i:s'));
        Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);

        if($isEmptyMessage && !$isNecessarilyMessage){
            return self::_sendEmptyMessages();
        }else {
            return self::_sendMessages($model);
        }
    }
}