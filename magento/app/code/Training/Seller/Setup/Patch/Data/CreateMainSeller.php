<?php

declare(strict_types=1);

namespace Training\Seller\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Training\Seller\Api\Data\SellerInterfaceFactory;
use Training\Seller\Api\SellerRepositoryInterface;

/**
 * Data patch that creates the main seller.
 */
class CreateMainSeller implements DataPatchInterface
{
    /**
     * @var SellerInterfaceFactory
     */
    private $sellerFactory;

    /**
     * @var SellerRepositoryInterface
     */
    private $sellerRepository;

    /**
     * @param SellerRepositoryInterface $sellerRepository
     * @param SellerInterfaceFactory $sellerFactory
     */
    public function __construct(
        SellerRepositoryInterface $sellerRepository,
        SellerInterfaceFactory $sellerFactory
    ) {
        $this->sellerRepository = $sellerRepository;
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $seller = $this->sellerFactory->create();
        $seller->setIdentifier('main');
        $seller->setName('Main Seller');

        $this->sellerRepository->save($seller);
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}