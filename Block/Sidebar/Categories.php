<?php
namespace Brituy\SimpleBlog\Block\Sidebar;

use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template\Context;
use Brituy\SimpleBlog\Model\Config;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Brituy\SimpleBlog\Api\Data\BlogInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\Collection as CategoriesCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\CollectionFactory as CategoriesCollectionFactory;

/** sidebar categories block */
class Categories extends Template implements IdentityInterface
{
    protected $_categoriesCollection;
    protected $_blogCollectionFactory;

    /** Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
     * @param array $data */
    public function __construct(Context $context, BlogCollectionFactory $blogCollectionFactory,
    					CategoriesCollectionFactory $categoriesCollection,array $data=[])
    {
        parent::__construct($context, $data);
        $this->_blogCollectionFactory = $blogCollectionFactory;
        $this->_categoriesCollection = $categoriesCollection;
    }

    public function getCategories()
    {
    	$categoriesList = $this->_categoriesCollection->create();

    	return $categoriesList;
    }
    
    public function getSelectedCategory()
    {
        $selCategory = $this->getRequest()->getParam('category_id');
        
        return $selCategory;
    }

    public function getArticlesCount($currentCategory)
    {
        $articlesByCategory = $this->_blogCollectionFactory
        				->create()
        				->addFilter('category_id', $currentCategory)
        				->addFilter('visibility', '1');
        $articlesByCategoryCount = $articlesByCategory->count();

	return $articlesByCategoryCount;
    }

    /** Return unique ID(s) for each object in system
     * @return string[]  */
    public function getIdentities()
    {
        return  $this->getCategories()->getIdentities();
    }

    /**
     * @return $this|AbstractBlock
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        if ($blog = $this->getBlog()) {
            $this->addBreadcrumbs();
            $this->pageConfig->setMetaTitle($blog->getMetaTitle());
            $this->pageConfig->getTitle()->set($blog->getMetaTitle() ?: $blog->getTitle());
        }
        return $this;
    }

}
