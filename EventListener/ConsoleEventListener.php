<?php

namespace WiziShop\ConsoleEventsLoggerBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;

use WiziShop\ConsoleEventsLoggerBundle\Logger\Logger;

class ConsoleEventListener implements EventSubscriberInterface
{
    private $logger;
    private $configuration;

    /**
     * @param Logger $logger
     * @param array  $configuration
     */
    public function __construct(Logger $logger, array $configuration)
    {
        $this->logger = $logger;
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => 'command',
            ConsoleEvents::TERMINATE => 'terminate',
            ConsoleEvents::EXCEPTION => 'error'
        ];
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function command(ConsoleCommandEvent $event)
    {
        if ($this->configuration['show_event_start']) {
            $this->logger->log(
                sprintf(
                    '`%s` => *%s* execution started',
                    $this->getNewDate(),
                    $this->getCommandDescription($event)
                )
            );
        }
    }

    /**
     * @param ConsoleTerminateEvent $event
     */
    public function terminate(ConsoleTerminateEvent $event)
    {
        if ($this->configuration['show_event_terminate']) {
            $this->logger->log(
                sprintf(
                    '`%s` => *%s* execution terminate',
                    $this->getNewDate(),
                    $this->getCommandDescription($event)
                )
            );
        }
    }

    /**
     * @param ConsoleExceptionEvent $event
     */
    public function error(ConsoleExceptionEvent $event)
    {
        $this->logger->log(
            sprintf(
                ':fire: :no_entry_sign: :fire: `%s` => *%s* execution is stopped ! :fire: :no_entry_sign: :fire: ```%s```',
                $this->getNewDate(),
                $this->getCommandDescription($event),
                $event->getError()->getMessage()
            )
        );
    }

    /**
     * @return string
     */
    private function getNewDate()
    {
        $date = (new \DateTime('now'))->format('Y-m-d H:i:s');

        return $date;
    }

    /**
     * @param ConsoleCommandEvent|ConsoleTerminateEvent|ConsoleExceptionEvent $event
     *
     * @return string
     */
    private function getCommandDescription($event)
    {
        if ($event->getCommand()) {

            return $event->getCommand()->getDescription() ? $event->getCommand()->getDescription() : $event->getCommand()->getName();
        }
    }
}
