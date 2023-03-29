<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Телеграм бот
 * Class Drivers_Telegram_Telegram
 */
class Drivers_Telegram_Telegram
{
    private $token = '';
    /**
     * @var null|\TelegramBot\Api\Client
     */
    private $botApi = null;
    /**
     * @var null|\TelegramBot\Api\BotApi
     */
    private $client = null;

    public function __construct($token)
    {
        require_once APPPATH . 'vendor/Telegram/autoload.php';
        $this->token = $token;
    }

    /**
     * Регистрация бота по ссылке
     * @param $url
     * @return boolean
     */
    public function registrationBot($url)
    {
        return $this->getBotApi()->setWebhook($url);
    }

    /**
     * @return null|\TelegramBot\Api\BotApi
     */
    public function getBotApi()
    {
        if($this->botApi == null){
            $this->botApi = new \TelegramBot\Api\BotApi($this->token);
        }

        return $this->botApi;
    }

    /**
     * @return null|\TelegramBot\Api\Client
     */
    public function getClient()
    {
        if($this->client == null){
            $this->client = new \TelegramBot\Api\Client($this->token);
        }

        return $this->client;
    }

    /**
     * Задаем команду
     * @param $name
     * @param Closure $action
     */
    public function command($name, Closure $action)
    {
        $this->getClient()->command($name, $action);
    }
}