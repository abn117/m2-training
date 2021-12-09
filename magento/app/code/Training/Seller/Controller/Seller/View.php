<?php

declare(strict_types=1);

namespace Training\Seller\Controller\Seller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\Page as PageResult;
use Training\Seller\Api\SellerRepositoryInterface;
use Training\Seller\Model\SellerRegistry;

/**
 * Seller view action.
 */
class View extends Action implements HttpGetActionInterface
{
    /**
     * @var SellerRegistry
     */
    private $sellerRegistry;

    /**
     * @var SellerRepositoryInterface
     */
    private $sellerRepository;

    /**
     * @param Context $context
     * @param SellerRegistry $sellerRegistry
     * @param SellerRepositoryInterface $sellerRepository
     */
    public function __construct(
        Context $context,
        SellerRegistry $sellerRegistry,
        SellerRepositoryInterface $sellerRepository
    ) {
        $this->sellerRegistry = $sellerRegistry;
        $this->sellerRepository = $sellerRepository;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        // Get the requested identifier
        $identifier = trim($this->getRequest()->getParam('identifier'));
        if (!$identifier) {
            throw new NotFoundException(__('The identifier is missing.'));
        }

        // Get the seller
        try {
            $seller = $this->sellerRepository->getByIdentifier($identifier);
        } catch (NoSuchEntityException $e) {
            throw new NotFoundException(__('The identifier does not exist.'));
        }

        // Save it to the registry
        $this->sellerRegistry->setCurrentSeller($seller);

        /** @var PageResult $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $result->getConfig()->getTitle()->set(__('Seller "%1"', $seller->getName()));

        return $result;
    }
}
