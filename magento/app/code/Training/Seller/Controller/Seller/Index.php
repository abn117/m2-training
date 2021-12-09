<?php

declare(strict_types=1);

namespace Training\Seller\Controller\Seller;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Raw as RawResult;
use Training\Seller\Api\SellerRepositoryInterface;

/**
 * Seller list action.
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {

        /** @var RawResult $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
//        $result->setContents($html);

        return $result;
    }
}
