<?php
namespace Brituy\SimpleBlog\Block\Sidebar;

use Brituy\SimpleBlog\Model\Config;
use Brituy\SimpleBlog\Model\Blog;
use Brituy\SimpleBlog\Model\BlogFactory;
use Brituy\SimpleBlog\Api\Data\BlogInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\AbstractBlock;

class Cms extends Template implements IdentityInterface
{
    const NUMBER_NEWEST_POSTS = 2;

    /** @var \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory */
    protected $_blogCollectionFactory;

    /** Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
     * @param array $data */
    public function __construct(Context $context,BlogCollectionFactory $blogCollectionFactory, array $data=[])
    {
        parent::__construct($context, $data);
        $this->_blogCollectionFactory = $blogCollectionFactory;
    }

    /*** Get newest Articles
     * @return ArticlesCollection
     * @throws NoSuchEntityException */
    public function getNewArticles()
    {
        $articles = $this->_blogCollectionFactory
				->create()
				->addFilter('visibility', 1)
				->addOrder(BlogInterface::BLOG_DATE, BlogCollection::SORT_ORDER_DESC)
				->setPageSize(self::NUMBER_NEWEST_POSTS);
	return $articles;
    }
    
    /** Return unique ID(s) for each object in system
     * @return string[]  */
    public function getIdentities()
    {
        return  $this->getArticle()->getIdentities();
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
