<?php


namespace Training\Seller\Model\ResourceModel\Seller;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Training\Seller\Model\Seller::class,
            \Training\Seller\Model\ResourceModel\Seller::class
        );
    }
}
