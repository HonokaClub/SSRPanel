<?php

namespace App\Components;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Log;

class TelegramBot
{
    protected static $systemConfig;

    function __construct()
    {
        self::$systemConfig = Helpers::systemConfig();
    }

    /**
     * 推送消息
     *
     * @param string $content 消息内容
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($title, $content)
    {
        $client = new Client();

        try {
            $response = $client->request('GET', 'https://api.telegram.org/bot%s/sendMessage' . self::$systemConfig['tgbot_token'] . '.send', [
                'query' => [
                    'chat_id' => self::$systemConfig['tgbot_channelid'],
                    'text' => $content,
                    'parse_mode' => 'Markdown'
                ]
            ]);

            $result = json_decode($response->getBody());
            if (!$result->errno) {
                Helpers::addServerChanLog($content);
            } else {
                Helpers::addServerChanLog($content, 0, $result->errmsg);
            }
        } catch (RequestException $e) {
            Log::error(Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::error(Psr7\str($e->getResponse()));
            }
        }
    }
}