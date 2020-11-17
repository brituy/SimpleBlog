<?php
//_init() method will define the resource model which will actually fetch the information from the database
namespace Brituy\SimpleBlog\Model;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'brituy_blog_main';
	protected $_cacheTag = 'brituy_blog_main';	//a unique identifier for use within caching
	protected $_eventPrefix = 'brituy_blog_main';	//a prefix for events to be triggered

	protected function _construct()
	{
		$this->_init('Brituy\SimpleBlog\Model\ResourceModel\Post');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];
		return $values;
	}
}
