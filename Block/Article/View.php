<?php
namespace Brituy\SimpleBlog\Block\Article;

use Brituy\SimpleBlog\Model\Config;
use Brituy\SimpleBlog\Model\Blog;
use Brituy\SimpleBlog\Model\BlogFactory;
use Brituy\SimpleBlog\Api\Data\BlogInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\Collection as CategoriesCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\CollectionFactory as CategoriesCollectionFactory;
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

class View extends Template implements IdentityInterface
{
    const NUMBER_RELATED_POSTS = 10;

    protected $_blogCollectionFactory;
    protected $config;

    /** Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
     * @param array $data */
    public function __construct(Context $context,BlogCollectionFactory $blogCollectionFactory,
    				CategoriesCollectionFactory $categoriesCollectionFactory,
    				AuthorsCollectionFactory $authorCollectionFactory,
    				Config $config,array $data=[])
    {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->_blogCollectionFactory = $blogCollectionFactory;
        $this->_authorCollectionFactory = $authorCollectionFactory;
        $this->_categoriesCollectionFactory = $categoriesCollectionFactory;
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
        $recentArticles = $this->_blogCollectionFactory->create();
        $recentArticles -> addFieldToFilter('visibility', Blog::STATUS_VISIBLE);
        $recentArticles -> addFieldToFilter('blog_id', ['neq' => $currentArticle->getColumnValues('blog_id')]);
        $recentArticles -> addFieldToFilter('category_id', $currentCategory)
            ->addOrder(BlogInterface::BLOG_DATE, BlogCollection::SORT_ORDER_DESC)
            ->setPageSize(self::NUMBER_RELATED_POSTS);

        return $recentArticles;
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
        return [\Brituy\SimpleBlog\Model\Blog::CACHE_TAG . '_' . 'article'];
    }

    /**
     * @return $this|AbstractBlock
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        $blogTitle = $this->config->getMenuTitle();
        $currentArticle = $this->getArticle()->getColumnValues('title');
        $currentCategory = $this->getArticle()->getColumnValues('category_id');
        $categoryName = $this->_categoriesCollectionFactory->create()->addFilter('category_id', $currentCategory)->getColumnValues('category');
        
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');

        if ($breadcrumbsBlock)
        {
            $breadcrumbsBlock->addCrumb('home',['label'=>__('Home'),
            					'title'=>__('Go to Home Page'),
            					'link'=>$this->_storeManager->getStore()->getBaseUrl(),]);
            $breadcrumbsBlock->addCrumb('blog',['label'=>__($blogTitle),
            					'title'=>__($blogTitle),
            					'link'=>$this->config->getBaseUrl(),]);
            $breadcrumbsBlock->addCrumb('category',['label'=>__($categoryName[0]),
            					'title'=>__($categoryName[0]),
            					'link'=>$this->getUrl('simpleblog',['category_id'=>$currentCategory[0]]),]);
            $breadcrumbsBlock->addCrumb('article',['label'=>__($currentArticle[0]),
            					'title'=>__($currentArticle[0]),
            					'link'=>null,]);
        }

        return $this;
    }

}
