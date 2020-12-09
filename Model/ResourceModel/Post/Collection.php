<?php
// collection model is considered a resource model which allow us to filter and fetch a collection table data
namespace Brituy\SimpleBlog\Model\ResourceModel\Post;

use Magento\Framework\DB\Select;
use Magento\Sales\Model\ResourceModel\Collection\AbstractCollection;
/**use Brituy\SimpleBlog\Api\Data\SearchResult\PostSearchResultInterface;**/
use Brituy\SimpleBlog\Model\Post;
use Zend_Db_Select;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'blog_id';
	protected $_eventPrefix = 'brituy_blog_main_collection';	//a prefix for events to be triggered
	protected $_eventObject = 'main_collection';			//a object name when access in event

	/** considered a resource model which allow us to filter and fetch a collection table data
	 * @return void */
	protected function _construct()
	{
		/**$this->_init('Brituy\SimpleBlog\Model\Post', 'Brituy\SimpleBlog\Model\ResourceModel\Post');**/
        $this->_init(Post::class,\Brituy\SimpleBlog\Model\ResourceModel\Post::class);
	}

}
