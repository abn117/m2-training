<?php

namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Training\Seller\Api\SellerRepositoryInterface;

class Index extends Action implements HttpGetActionInterface
{
    private SellerRepositoryInterface $sellerRepository;

    public function __construct(\Magento\Backend\App\Action\Context $context, SellerRepositoryInterface $sellerRepository)
    {
        parent::__construct($context);
        $this->sellerRepository = $sellerRepository;
    }

    public function execute()
    {
        $mainSeller = $this->sellerRepository->getById(1);
        if (!$mainSeller) {
            return null;
        }
        dd($mainSeller->getName());
    }
}
