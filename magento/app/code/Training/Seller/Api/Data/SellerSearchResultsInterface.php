<?php


namespace Training\Seller\Api\Data;

interface SellerSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Seller list.
     * @return \Training\Seller\Api\Data\SellerInterface[]
     */
    public function getItems();

    /**
     * Set seller_id list.
     * @param \Training\Seller\Api\Data\SellerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
