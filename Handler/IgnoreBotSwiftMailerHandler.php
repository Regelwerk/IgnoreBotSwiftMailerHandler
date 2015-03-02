<?php

namespace Regelwerk\IgnoreBotSwiftMailerHandlerBundle\Handler;

use Symfony\Bridge\Monolog\Handler\SwiftMailerHandler;

/**
 * Description of IgnoreBotSwiftMailerHandler
 *
 * @author georg
 */
class IgnoreBotSwiftMailerHandler extends SwiftMailerHandler {

    /**
     * {@inheritdoc}
     */
    public function handle(array $record) {
        if (!$this->isHandling($record)) {
            return false;
        }

        $record = $this->processRecord($record);
        if (isset($record['extra']['isBot']) && $record['extra']['isBot']) {
            unset($record['extra']['isBot']);
            $record['formatted'] = $this->getFormatter()->format($record);

            $this->write($record);
        }

        return false === $this->bubble;
    }

    /**
     * {@inheritdoc}
     */
    public function handleBatch(array $records) {
        $messages = array();

        foreach ($records as $record) {
            if (!$this->isHandling($record)) {
                continue;
            }
            $record = $this->processRecord($record);
            if (isset($record['extra']['isBot']) && $record['extra']['isBot']) {
                unset($record['extra']['isBot']);
                $messages[] = $record;
            }
        }

        if (!empty($messages)) {
            $this->send((string) $this->getFormatter()->formatBatch($messages), $messages);
        }
    }

}
