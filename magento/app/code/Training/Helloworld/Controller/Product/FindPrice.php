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
use Magento\Framework\Data\Collection;

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
        $productCollection
            ->addAttributeToFilter('price', ['gt' => '30'])
            ->setPageSize(10)
            ->setOrder('name', Collection::SORT_ORDER_ASC);

        $filteredProducts = $productCollection->getItems();

        dump($filteredProducts);die();

        foreach ($filteredProducts as $product) {
            $price = $this->priceCurrency->format($product->getPrice())
            // $prds[] = $product->getName();
        }


        /** @var RawResult $result */
        $productResults = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        return $productResults->setContents(__('Products: %1', $prds));
    }
}
