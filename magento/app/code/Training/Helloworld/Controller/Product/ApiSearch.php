<?php

declare(strict_types=1);

namespace Training\Helloworld\Controller\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Raw as RawResult;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Controller\ResultFactory;


class ApiSearch extends Action implements HttpGetActionInterface
{
    private $productRepository;
    private $searchCriteriaBuilder;
    private $sortOrderBuilder;


    /** @param Context $context */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    public function execute()
    {
        $sorted = $this->sortOrderBuilder
            ->setField('name')
            ->setDescendingDirection()
            ->create();
        $searchByCriteria = $this->searchCriteriaBuilder
            ->addFilter('description', '%comfortable%', 'like')
            ->addSortOrder($sorted)
            ->setPageSize(6)
            ->setCurrentPage(1)
            ->create();
        $items = $this->productRepository->getList($searchByCriteria)->getItems();

        foreach ($items as $product) {
            echo $product->getDescription() . '' . $product->getName();
        }

        /** @var RawResult $result */
        // $productResults = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        // return $productResults->setContents(__('Products: %1', $productList));
    }
}
