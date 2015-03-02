<?php

namespace Regelwerk\IgnoreBotSwiftMailerHandlerBundle\Processor;

use Symfony\Component\HttpFoundation\RequestStack;
use Vipx\BotDetectBundle\BotDetector;

/**
 * Description of BotProcessor
 *
 * @author georg
 */
class BotProcessor {

    private $isBot = '', $enabled;

    public function __construct(RequestStack $requestStack, BotDetector $detector, $enabled) {
        $this->enabled = $enabled;
        if ($enabled) {
            $request = $requestStack->getMasterRequest();
            if (!is_null($request)) {
                $this->isBot = !is_null($detector->detectFromRequest($request));
            }
        }
    }

    public function __invoke(array $record) {
        if ($this->enabled) {
            $record['extra']['isBot'] = $this->isBot;
        }
        return $record;
    }

}
