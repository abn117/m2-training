<?php

declare(strict_types=1);

namespace Training\Helloworld\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as BaseProductFactory;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Raw as RawResult;
use Magento\Framework\App\Action\Context;

class FindPrice extends Action implements HttpGetActionInterface
{

    /** @var BaseProductFactory  */
    private $productFactory;
    /** @var PriceCurrencyInterface */
    private $priceCurrency;

    /** @param Context $context */
    public function __construct(Context $context, BaseProductFactory $productFactory, PriceCurrencyInterface $priceCurrency)
    {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->priceCurrency = $priceCurrency;
    }

    public function execute()
    {
        $prds = [];
        $productCollection = $this->productFactory->create();
        $productCollection->addAttributeToFilter('price', ['gt' => '30']);
        
        $filteredProducts = $productCollection->getItems();
        dump($filteredProducts);die();

        foreach ($filteredProducts as $product) {
            $prds[] = $product->getName();
        }
        
        // $res = "rien";

        /** @var RawResult $result */
        $productResults = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        return $productResults->setContents(__('Products: %1', $prds));
    }
}
