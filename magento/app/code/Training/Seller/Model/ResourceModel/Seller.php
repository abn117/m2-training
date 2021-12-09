<?php


namespace Training\Seller\Model\ResourceModel;

class Seller extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('training_seller_seller', 'seller_id');
    }
}
