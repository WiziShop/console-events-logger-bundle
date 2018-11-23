<?php

namespace WiziShop\ConsoleEventsLoggerBundle\Logger;

use ThreadMeUp\Slack\Client;

class Logger
{
    private $environment;
    private $configuration;

    /**
     * @param string $environment
     * @param array  $configuration
     */
    public function __construct($environment, array $configuration)
    {
        $this->environment = $environment;
        $this->configuration = $configuration;
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function log($message)
    {
        if ($this->configuration['activated']) {
            $this->sendMessageRoom(
                new Client([
                    'token' => $this->configuration['token'],
                    'username' => $this->configuration['username'],
                    'icon' => $this->configuration['icon'],
                    'parse' => ''
                ]),
                $message
            );
        }
    }

    /**
     * @param Client $slack
     * @param string $message
     *
     * @return bool
     */
    private function sendMessageRoom(Client $slack, $message)
    {
        try {
            $chat = $slack->chat($this->configuration['room_name']);
            $chat->send($message);
        } catch (\Exception $e) {

            return false;
        }
    }
}
