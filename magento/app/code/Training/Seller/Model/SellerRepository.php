<?php


namespace Training\Seller\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Training\Seller\Model\ResourceModel\Seller as ResourceSeller;
use Training\Seller\Api\Data\SellerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Training\Seller\Api\SellerRepositoryInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Training\Seller\Model\ResourceModel\Seller\CollectionFactory as SellerCollectionFactory;
use Training\Seller\Api\Data\SellerSearchResultsInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;

class SellerRepository implements SellerRepositoryInterface
{

    protected $dataObjectHelper;

    protected $dataSellerFactory;

    protected $extensibleDataObjectConverter;
    protected $resource;

    private $storeManager;

    protected $sellerFactory;

    protected $searchResultsFactory;

    private $collectionProcessor;

    protected $sellerCollectionFactory;

    protected $extensionAttributesJoinProcessor;

    protected $dataObjectProcessor;


    /**
     * @param ResourceSeller $resource
     * @param SellerFactory $sellerFactory
     * @param SellerInterfaceFactory $dataSellerFactory
     * @param SellerCollectionFactory $sellerCollectionFactory
     * @param SellerSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSeller $resource,
        SellerFactory $sellerFactory,
        SellerInterfaceFactory $dataSellerFactory,
        SellerCollectionFactory $sellerCollectionFactory,
        SellerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->sellerFactory = $sellerFactory;
        $this->sellerCollectionFactory = $sellerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSellerFactory = $dataSellerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Training\Seller\Api\Data\SellerInterface $seller
    ) {
        /* if (empty($seller->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $seller->setStoreId($storeId);
        } */
        
        $sellerData = $this->extensibleDataObjectConverter->toNestedArray(
            $seller,
            [],
            \Training\Seller\Api\Data\SellerInterface::class
        );
        
        $sellerModel = $this->sellerFactory->create()->setData($sellerData);
        
        try {
            $this->resource->save($sellerModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the seller: %1',
                $exception->getMessage()
            ));
        }
        return $sellerModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($sellerId)
    {
        $seller = $this->sellerFactory->create();
        $this->resource->load($seller, $sellerId);
        if (!$seller->getId()) {
            throw new NoSuchEntityException(__('Seller with id "%1" does not exist.', $sellerId));
        }
        return $seller->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->sellerCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Training\Seller\Api\Data\SellerInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Training\Seller\Api\Data\SellerInterface $seller
    ) {
        try {
            $sellerModel = $this->sellerFactory->create();
            $this->resource->load($sellerModel, $seller->getSellerId());
            $this->resource->delete($sellerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Seller: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($sellerId)
    {
        return $this->delete($this->getById($sellerId));
    }
}
