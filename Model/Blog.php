<?php
namespace Brituy\SimpleBlog\Model;

use Brituy\SimpleBlog\Api\Data\BlogInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Data\Collection\AbstractDb;

class Blog extends AbstractModel implements BlogInterface, IdentityInterface
{
    /** Post's Statuses */
    const STATUS_VISIBLE = 1;
    const STATUS_UNVISIBLE = 0;

    /** CMS page cache tag */
    const CACHE_TAG = 'blog_main';

    /** @var string */
    protected $_cacheTag = 'blog_main';

    /** Prefix of model events names
     * @var string */
    protected $_eventPrefix = 'blog_main';

    /** @var \Magento\Framework\UrlInterface */
    protected $_urlBuilder;
    
    public function __construct(Context $context,Registry $registry,UrlInterface $urlBuilder,
    					AbstractResource $resource = null,AbstractDb $resourceCollection = null,
					array $data = [])
    {
	    $this->_urlBuilder = $urlBuilder;
	    parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    
    protected function _construct()
    {
        $this->_init('Brituy\SimpleBlog\Model\ResourceModel\Blog');
    }
    
    /** Return unique ID(s) for each object in system
     ** @return array */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    
    /** Get blog ID
     ** @return int|null */
    public function getBlogId()
    {
    	return $this->getData(self::BLOG_ID);
    }
    
    /** Get category ID
     ** @return int|null */
    public function getCategoryId()
    {
    	return $this->getData(self::CATEGORY_ID);
    }
    
    /** Get Visibility
     ** @return bool|null */
    public function getVisibility()
    {
    	return (bool) $this->getData(self::VISIBILITY);
    }
    
    /** Get creation date
     ** @return string|null */
    public function getBlogDate()
    {
        return $this->getData(self::BLOG_DATE);
    }

    /** Get title
     ** @return string|null */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /** Get content
     ** @return string|null */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /** Get content
     ** @return string|null */
    public function getShortContent()
    {
        $fullContent = $this->getData(self::CONTENT);
        $shortContent = substr($fullContent, 0, 160);
        
        return $shortContent;
    }
    
    

    /** Set blog ID
     ** @param int $blogid
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface */
    public function setBlogId($blogid)
    {
        return $this->setData(self::BLOG_ID, $blogid);
    }
    
    /** Set category ID
     ** @param int $categoryid
     ** @return int|null */
    public function setCategoryId($categoryid)
    {
    	return $this->setData(self::CATEGORY_ID, $categoryid);
    }
    
    /** Set is visibility
     ** @param int|bool $visibility
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface */
    public function setVisibility($visibility)
    {
        return $this->setData(self::VISIBILITY, $visibility);
    }

    /** Set creation date
     ** @param string $blogDate
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface */
    public function setBlogDate($blogDate)
    {
        return $this->setData(self::BLOG_DATE, $blogDate);
    }
    
    /** Set title
     ** @param string $title
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /** Set content
     ** @param string $content
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }  
}
