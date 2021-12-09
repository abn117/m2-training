<?php

namespace Training\Seller\Controller;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @param ActionFactory $actionFactory
     */
    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    /**
     * @inheritdoc
     */
    public function match(RequestInterface $request)
    {
        /** @var HttpRequest $request */
        $url = $request->getPathInfo();

        if ($url === '/sellers.html') {
            $request->setPathInfo('/seller/seller/index');
            return $this->actionFactory->create(Forward::class);
        }

        if (preg_match('%^/seller/(.+)\.html$%', $url, $match)) {
            $request->setPathInfo(sprintf('/seller/seller/view/identifier/%s', $match[1]));
            return $this->actionFactory->create(Forward::class);
        }

        return null;
    }

}
