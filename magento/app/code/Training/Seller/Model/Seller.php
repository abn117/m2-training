<?php


namespace Training\Seller\Model;

use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Api\Data\SellerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Seller extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'training_seller';
    protected $sellerDataFactory;

    protected $dataObjectHelper;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SellerInterfaceFactory $sellerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Training\Seller\Model\ResourceModel\Seller $resource
     * @param \Training\Seller\Model\ResourceModel\Seller\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SellerInterfaceFactory $sellerDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Training\Seller\Model\ResourceModel\Seller $resource,
        \Training\Seller\Model\ResourceModel\Seller\Collection $resourceCollection,
        array $data = []
    ) {
        $this->sellerDataFactory = $sellerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve seller model with seller data
     * @return SellerInterface
     */
    public function getDataModel()
    {
        $sellerData = $this->getData();
        
        $sellerDataObject = $this->sellerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $sellerDataObject,
            $sellerData,
            SellerInterface::class
        );
        
        return $sellerDataObject;
    }
}
