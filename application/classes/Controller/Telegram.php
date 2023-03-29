<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Telegram extends Controller_Client_BasicShop
{
    /**
     * @var Drivers_Telegram_Telegram|null
     */
    protected $telegram = null;
    /**
     * Настройки
     * @var array
     */
    protected $options = array();

    public function __construct(Request $request, Response $response, $languageID = Model_Language::LANGUAGE_RUSSIAN)
    {
        parent::__construct($request, $response);

        // Магазин
        $this->_readShopInterface();

        // шаблон магазина
        $this->_readSiteShablonInterface($this->_sitePageData->shop->getSiteShablonID());

        $path = APPPATH.'views'.DIRECTORY_SEPARATOR.$this->_sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR.$languageID.'.php';
        if(!file_exists($path)){
            throw new HTTP_Exception_404('Telegram options not found.');
        }
        $this->options = include $path;

        $this->telegram = new Drivers_Telegram_Telegram($this->options['token']);
    }

    /**
     * Список команд телеграм бота
     */
    protected function commands()
    {
        $bot = $this->telegram->getClient();


        // обязательное. Запуск бота
        $bot->command('start', function ($message) use ($bot) {
            $answer = 'Добро пожаловать!';
            $bot->sendMessage($message->getChat()->getId(), $answer);
        });

        // помощ
        $bot->command('help', function ($message) use ($bot) {
            $answer = 'Команды:'."\r\n".'/help - помощь.';
            $bot->sendMessage($message->getChat()->getId(), $answer);
        });

        $bot->run();
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/telegram/index';

        // список команд
        $this->commands();
    }

    public function action_registration()
    {
        $this->_sitePageData->url = '/telegram/registration';

        if($this->telegram->registrationBot($this->_sitePageData->urlBasic.'/telegram/index')){
            echo 'Bot registered "'.$this->_sitePageData->urlBasic.'/telegram/index".';
        }else{
            echo 'Bot NOT registered.';
        }
    }

    public function isAccess(){}
}