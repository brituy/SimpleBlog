<?php
namespace Brituy\SimpleBlog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template\Context;
use Brituy\SimpleBlog\Api\Data\BlogInterface;
use Brituy\SimpleBlog\Model\Config;
use Brituy\SimpleBlog\Model\Blog;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\Collection as CategoriesCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Categories\CollectionFactory as CategoriesCollectionFactory;

class BlogList extends Template implements IdentityInterface
{
    /** @var \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory */
    protected $blogCollectionFactory;
    protected $config;

    /** Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
     * @param array $data */
    public function __construct(Context $context,BlogCollectionFactory $blogCollectionFactory,
    				CategoriesCollectionFactory $categoriesCollectionFactory,
    				Config $config,array $data=[])
    {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->_categoriesCollectionFactory = $categoriesCollectionFactory;
    }

    public function getBaseUrlConfig()
    {
            return $this->config->getBaseRoute();
    }

    /**
     * @return \Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection
     */
    public function getArticles()
    {
        //get values of current page
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 1;
        //get value of current filter
        $categoryid = $this->getRequest()->getParam('category_id');

        // Check if articles has already been defined makes our block nice and re-usable! We could
        // pass the 'articles' data to this block, with a collection that has been filtered differently!
        if (!$this->hasData('articles'))
        {
            if ($categoryid)
            {
                $articles = $this->blogCollectionFactory
				->create()
				->addFilter('visibility', 1)
				->addFilter('category_id', $categoryid)
				->addOrder(BlogInterface::BLOG_DATE, BlogCollection::SORT_ORDER_DESC)
				->setPageSize($pageSize)
				->setCurPage($page);
	    }else{
	        $articles = $this->blogCollectionFactory
				->create()
				->addFilter('visibility', 1)
				->addOrder(BlogInterface::BLOG_DATE, BlogCollection::SORT_ORDER_DESC)
				->setPageSize($pageSize)
				->setCurPage($page);
	    }

            $this->setData('articles', $articles);
        }

        return $this->getData('articles');
    }

    /** Return identifiers for produced content
     * @return array */
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
        $blogTitle = $this->config->getMenuTitle();
        $categoryid = $this->getRequest()->getParam('category_id');
        $categoryName = $this->_categoriesCollectionFactory->create()->addFilter('category_id', $categoryid)->getColumnValues('category');

        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');

        if ($breadcrumbsBlock)
        {
            $breadcrumbsBlock->addCrumb('home',['label'=>__('Home'),
            					'title'=>__('Go to Home Page'),
            					'link'=>$this->_storeManager->getStore()->getBaseUrl()]);
            if ($categoryid)
            {
                $breadcrumbsBlock->addCrumb('blog',['label'=>__($blogTitle),'title'=>__($blogTitle),'link'=>$this->config->getBaseUrl(),]);
                $breadcrumbsBlock->addCrumb('category',['label'=>__($categoryName[0]),'title'=>__($categoryName[0]),'link'=>null,]);
            }else { $breadcrumbsBlock->addCrumb('blog',['label'=>__($blogTitle),'title'=>__($blogTitle),'link'=>null,]); }
        }

        if ($this->getArticles())
        {
            $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager','custom.blog.pager')
 				                        ->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
 				                        ->setShowPerPage(true)
 				                        ->setCollection($this->getArticles());

            $this->setChild('pager', $pager);
            $this->getArticles()->load();
        }

        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
