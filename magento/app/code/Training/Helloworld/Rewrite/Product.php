<?php

namespace Training\Helloworld\Rewrite;

use Magento\Catalog\Model\Product as BaseProduct;

class Product extends BaseProduct {

    public function getName()
    {
        $parentName = parent::getName();
        
        return mb_convert_case($parentName, MB_CASE_UPPER);
    }
}
