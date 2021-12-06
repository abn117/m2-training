<?php

declare(strict_types=1);

namespace Training\Helloworld\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;

class SendResponseLogOutput implements ObserverInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;   
    }

    public function execute($ob): void
    {
        $req = $ob->getEvent()->getData('request');
        $url = $req->getPathInfo();

        $this->logger->debug(__('THIS LOG *** BANG BANG %1', $url));
        
        //Isolate into file
        //@todo Bonus
    }
}
