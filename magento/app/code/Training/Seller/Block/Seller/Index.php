<?php

namespace Training\Seller\Block\Seller;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Training\Seller\Api\SellerRepositoryInterface;

class Index extends Template
{
    /**
     * @var SellerRepositoryInterface
     */
    private $sellerRepository;

    private SearchCriteriaInterface $criteria;

    /**
     * @param Context $context
     * @param SellerRepositoryInterface $sellerRepository
     */
    public function __construct(Context $context, SellerRepositoryInterface $sellerRepository, SearchCriteriaInterface $criteria)
    {
        $this->sellerRepository = $sellerRepository;
        parent::__construct($context);
        $this->criteria = $criteria;
    }

    public function getCustomList()
    {
        $searchResult = $this->sellerRepository->getList($this->criteria);

        $html = '<ul>';
        foreach ($searchResult->getItems() as $seller) {
            $html .= '<li><a href="/seller/' . $seller->getIdentifier() . '.html">' . $seller->getName() . '</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
