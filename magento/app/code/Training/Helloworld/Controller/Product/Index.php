<?php

declare(strict_types=1);

namespace Training\Helloworld\Controller\Product;

use Magento\Framework\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Raw as RawResult;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;


    /**
     * 
     * @param Context $context 
     * @param ProductRepositoryInterface $productRepository 
     */
    public function __construct(Context $context, ProductRepositoryInterface $productRepository)
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
    }

    public function execute()
    {
        $productId = $this->getRequest()->getParam('id');

        $product = $this->productRepository->getById($productId);

        /** @var RawResult $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        return $result->setContents(__('Product: %1', $product->getName()));
    }
}
