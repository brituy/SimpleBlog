<?php
namespace Brituy\SimpleBlog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template\Context;
use Brituy\SimpleBlog\Api\Data\BlogInterface;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection as BlogCollection;
use Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory;

class BlogList extends Template implements IdentityInterface
{
    /** @var \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory */
    protected $_blogCollectionFactory;

    /** Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Brituy\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory $blogCollectionFactory,
     * @param array $data */
    public function __construct(Context $context,CollectionFactory $blogCollectionFactory,array $data=[])
    {
        parent::__construct($context, $data);
        $this->_blogCollectionFactory = $blogCollectionFactory;
    }

    /**
     * @return \Brituy\SimpleBlog\Model\ResourceModel\Blog\Collection
     */
    public function getArticles()
    {
        // Check if articles has already been defined
        // makes our block nice and re-usable! We could
        // pass the 'articles' data to this block, with a collection
        // that has been filtered differently!
        if (!$this->hasData('articles'))
        {
            $categoryid = $this->getRequest()->getParam('category_id');
            if ($categoryid)
            {
                $articles = $this->_blogCollectionFactory
				->create()
				->addFilter('visibility', 1)
				->addFilter('category_id', $categoryid)
				->addOrder(BlogInterface::BLOG_DATE, BlogCollection::SORT_ORDER_DESC);
	    }else{
	        $articles = $this->_blogCollectionFactory
				->create()
				->addFilter('visibility', 1)
				->addOrder(BlogInterface::BLOG_DATE, BlogCollection::SORT_ORDER_DESC);
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

}
