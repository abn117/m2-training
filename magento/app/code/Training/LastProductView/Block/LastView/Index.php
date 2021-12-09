<?php

namespace Training\LastProductView\Block\LastView;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Index extends Template
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(Context $context, ProductRepositoryInterface $productRepository, array $data = [])
    {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
    }

    public function getLastProduct() {
        return $this->productRepository->getById(1)->getSku();
    }


}
