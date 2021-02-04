<?php
namespace Brituy\SimpleBlog\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Url;
use Brituy\SimpleBlog\Model\Config;
use Brituy\SimpleBlog\Model\BlogFactory;

class Router implements RouterInterface
{
    protected $actionFactory;
    protected $_response;
    protected $config;
    protected $blogFactory;

    /** @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response */
    public function __construct(ActionFactory $actionFactory,ResponseInterface $response,Config $config,BlogFactory $blogFactory)
    {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->config = $config;
        $this->blogFactory = $blogFactory;
    }

    /** Validate and Match
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $identifierParts = explode('/', $identifier);
        $baseUrl = $this->config->getBaseRoute();

        if ($identifierParts[0] != 'blog') { return false; }

        if ($identifierParts[0] == 'blog' && !isset($identifierParts[1]))
        {
            $request->setModuleName($baseUrl);
            $request->setControllerName('index');
            $request->setActionName('index');
            $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);

            return $this->actionFactory->create(Forward::class);
        }
        
        if (isset($identifierParts[1]) && !empty($identifierParts[1])) 
        {
            $request->setModuleName($baseUrl);
            $request->setControllerName('article');
            $request->setActionName('view');
            $request->setParam('blog_id', $identifierParts[1]);
            $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, '/' . $identifierParts[1]);

            return $this->actionFactory->create(Forward::class);
        }
    }
}
