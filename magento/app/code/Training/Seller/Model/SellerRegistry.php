<?php

declare(strict_types=1);

namespace Training\Seller\Model;

use Magento\Framework\Api\SearchResults;

/**
 * Seller registry.
 */
class SellerRegistry
{
    /**
     * @var Seller
     */
    private $seller;

    /**
     * @var SearchResults
     */
    private $searchResults;

    /**
     * Get the current seller.
     *
     * @return Seller
     */
    public function getCurrentSeller(): Seller
    {
        return $this->seller;
    }

    /**
     * Set the current seller.
     *
     * @param Seller $seller
     * @return $this
     */
    public function setCurrentSeller(Seller $seller): SellerRegistry
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get the current seller.
     *
     * @return SearchResults
     */
    public function getSearchResults(): SearchResults
    {
        return $this->searchResults;
    }

    /**
     * Set the current seller.
     *
     * @param SearchResults $searchResults
     * @return $this
     */
    public function setSearchResults(SearchResults $searchResults): SellerRegistry
    {
        $this->searchResults = $searchResults;

        return $this;
    }
}
