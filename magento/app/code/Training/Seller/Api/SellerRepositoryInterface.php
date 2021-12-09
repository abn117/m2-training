<?php


namespace Training\Seller\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SellerRepositoryInterface
{

    /**
     * Save Seller
     * @param \Training\Seller\Api\Data\SellerInterface $seller
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Training\Seller\Api\Data\SellerInterface $seller
    );

    /**
     * Retrieve Seller
     * @param string $sellerId
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sellerId);

    /**
     * Retrieve Seller matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Training\Seller\Api\Data\SellerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Seller
     * @param \Training\Seller\Api\Data\SellerInterface $seller
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Training\Seller\Api\Data\SellerInterface $seller
    );

    /**
     * Delete Seller by ID
     * @param string $sellerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sellerId);

    public function getByIdentifier($identifier);
}
