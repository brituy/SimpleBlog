<?php
namespace Brituy\SimpleBlog\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface as MagentoUrlInterface;

class Config
{
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        MagentoUrlInterface $urlManager
    ) {
        $this->scopeConfig  = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->urlManager   = $urlManager;
    }
    
    /** @param null|string $store
     ** @return string */
    public function getMenuTitle($store = null)
    {
        return $this->scopeConfig->getValue('simpleblog/general/menu_title', ScopeInterface::SCOPE_STORE, $store);
    }
    
    /** @return bool */
    public function isDisplayInMenu()
    {
        return $this->scopeConfig->getValue('simpleblog/general/blog_enable',ScopeInterface::SCOPE_STORE);
    }
    
    /** @return string */
    public function getBaseUrl()
    {
        return $this->urlManager->getUrl($this->getBaseRoute());
    }

    /** @return string */
    public function getBaseRoute()
    {
        return $this->scopeConfig->getValue('simpleblog/general/base_route');
    }
}
