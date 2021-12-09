<?php


namespace Training\Seller\Api\Data;

interface SellerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const IDENTIFIER = 'identifier';
    const NAME = 'name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const SELLER_ID = 'seller_id';

    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId();

    /**
     * Set seller_id
     * @param string $sellerId
     * @return \Training\Seller\Api\Data\SellerInterface
     */
    public function setSellerId($sellerId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Training\Seller\Api\Data\SellerExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Training\Seller\Api\Data\SellerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Training\Seller\Api\Data\SellerExtensionInterface $extensionAttributes
    );

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \Training\Seller\Api\Data\SellerInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Training\Seller\Api\Data\SellerInterface
     */
    public function setName($name);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Training\Seller\Api\Data\SellerInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Training\Seller\Api\Data\SellerInterface
     */
    public function setUpdatedAt($updatedAt);
}
