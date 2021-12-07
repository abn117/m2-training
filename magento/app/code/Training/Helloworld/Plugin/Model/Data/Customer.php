<?php

declare(strict_types=1);

namespace Training\Helloworld\Plugin\Model\Data;

use Magento\Customer\Model\Data\Customer as CustomerModel;

class Customer
{
    public function beforeSetFirstname(CustomerModel $subject, $value): array
    {
        return [mb_convert_case($value, MB_CASE_TITLE)];
    }

    public function beforeSetLastname(CustomerModel $subject, $value): array
    {
        return [mb_convert_case($value, MB_CASE_TITLE)];
    }
}
