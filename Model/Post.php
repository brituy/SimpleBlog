<?php namespace Brituy\SimpleBlog\Model;

use Brituy\SimpleBlog\Api\Data\PostInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Post extends \Magento\Framework\Model\AbstractModel implements PostInterface
{

    /**#@+
     * Post's Statuses
     */
    const STATUS_VISIBLE = 1;
    const STATUS_UNVISIBLE = 0;
    /**#@-*/

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'simpleblog_post';

    /**
     * @var string  a unique identifier for use within caching
     */
    protected $_cacheTag = 'simpleblog_post';

    /**
     * Prefix of model events names, to be triggered
     * @var string
     */
    protected $_eventPrefix = 'simpleblog_post';

    /**
     * Initialize resource model This allows us to initialise our resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Brituy\SimpleBlog\Model\ResourceModel\Post');
    }

    /**
     * Check if post key exists
     * return post id if post exists
     * @param int $blogid
     * @return int
     */
    public function checkBlogId($blogid)
    {
        return $this->_getResource()->checkBlogId($blogid);
    }
    
    /**
     * Prepare post's statuses.
     * Available event blog_post_get_available_statuses to customize statuses.
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_VISIBLE => __('Visible'), self::STATUS_UNVISIBLE => __('Unvisible')];
    }
    
    /**
     * Get BlogID
     * @return int|null
     */
    public function getBlogId()
    {
        return $this->getData(self::BLOG_ID);
    }

    /**
     * get visibility
     * @return bool|null
     */
    public function getVisibility()
    {
        return (bool) $this->getData(self::VISIBILITY);
    }
    
    /**
     * Get CATEGORY_ID
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }
    
    /**
     * Get AUTHOR_ID
     * @return int|null
     */
    public function getAuthorId()
    {
        return $this->getData(self::AUTHOR_ID);
    }
    
    /**
     * Get date
     * @return string|null
     */
    public function getDate()
    {
        return $this->getData(self::DATE);
    }
    
    /**
     * Get title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get CONTENT
     * @return Blob|null
     */
    public function getContent()
    {
        return $this->getData(self::Content);
    }

    /**
     * Set blog ID
     * @param int $blogid
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setBlogId($blogid)
    {
        return $this->setData(self::BLOG_ID, $blogid);
    }

    /**
     * Set visibility
     * @param int|bool $visibility
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setVisibility($visibility)
    {
        return $this->setData(self::VISIBILITY, $visibility);
    }
    
    /**
     * Set category ID
     * @param int $categoryid
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setCategoryId($categoryid)
    {
        return $this->setData(self::CATEGORY_ID, $categoryid);
    }
    
    /**
     * Set author ID
     * @param int $authorid
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setAuthorId($authorid)
    {
        return $this->setData(self::AUTHOR_ID, $authorid);
    }
    
    /**
     * Set date
     * @param string $creationDate
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setDate($creationDate)
    {
        return $this->setData(self::DATE, $creationDate);
    }
    
    /**
     * Set title
     * @param string $title
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     * @param string $content
     * @return \Brituy\SimpleBlog\Api\Data\PostInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

}
