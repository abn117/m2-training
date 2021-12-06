<?php

declare(strict_types=1);

namespace Training\Helloworld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Raw as RawResult;
use Magento\Framework\Controller\ResultFactory;


/**
 * Default action.
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var RawResult $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        return $result->setContents(__('Hello World!'));
    }
}
