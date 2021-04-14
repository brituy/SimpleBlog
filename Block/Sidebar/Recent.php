<?php
namespace Brituy\SimpleBlog\Block\Sidebar;

use Brituy\SimpleBlog\Model\Config;
use Brituy\SimpleBlog\Model\Blog;
use Brituy\SimpleBlog\Model\BlogFactory;
use Brituy\SimpleBlog\Api\Data\BlogInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\Collection as AuthorsCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Authors\CollectionFactory as AuthorsCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\AbstractBlock;

class Recent extends Template implements IdentityInterface
{
    const NUMBER_RELATED_POSTS = 10;

    /** @var \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory */
    protected $_blogCollectionFactory;
    
    /** @var \Brituy\SimpleBlog\Model\ResourceModel\Author\CollectionFactory */
    protected $_authorCollectionFactory;
    protected $config;

    /** Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
     * @param array $data */
    public function __construct(Context $context,BlogCollectionFactory $blogCollectionFactory,
    				AuthorsCollectionFactory $authorCollectionFactory,
    				Config $config,array $data=[])
    {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->_blogCollectionFactory = $blogCollectionFactory;
        $this->_authorCollectionFactory = $authorCollectionFactory;
    }
    
    public function getBaseUrlConfig()
    {
            return $this->config->getBaseRoute();
    }

    /** @return Article|null */
    public function getArticle()
    {
        $blogid = $this->getRequest()->getParam('blog_id');
        
        //return $this->blogFactory->create()->load($blogid);
        $article = $this->_blogCollectionFactory
        	->create()
        	->addFilter('blog_id', $blogid);
        $this->setData('article', $article);
        
        return $this->getData('article');
    }

    /*** Get recent Articles
     * @return ArticlesCollection
     * @throws NoSuchEntityException */
    public function getRecentArticles()
    {
        $currentArticle = $this->getArticle();
        $currentCategory = $this->getArticle()->getColumnValues('category_id');
        
        if ($currentCategory)
        {
            $recentArticles = $this->_blogCollectionFactory->create();
            $recentArticles -> addFieldToFilter('visibility', Blog::STATUS_VISIBLE);
            $recentArticles -> addFieldToFilter('blog_id', ['neq' => $currentArticle->getColumnValues('blog_id')]);
            $recentArticles -> addFieldToFilter('category_id', $currentCategory)
				->addOrder(BlogInterface::BLOG_DATE, BlogCollection::SORT_ORDER_DESC)
				->setPageSize(self::NUMBER_RELATED_POSTS);
            return $recentArticles;
        } else { return null; }
    }
    
    public function getAuthor()
    {
    	$currentArticle = $this->getArticle();
    	$currentAuthorId = $this->getArticle()->getColumnValues('author_id');
    	$authorCollection = $this->_authorCollectionFactory
    					->create()
    					->addFilter('author_id', $currentAuthorId);
    	return $authorCollection;
    }

    /** Return unique ID(s) for each object in system
     * @return string[]  */
    public function getIdentities()
    {
        return [\Brituy\SimpleBlog\Model\Blog::CACHE_TAG . '_' . 'list'];
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
