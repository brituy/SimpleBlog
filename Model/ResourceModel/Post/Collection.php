<?php namespace Brituy\SimpleBlog\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'blog_id';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Brituy\SimpleBlog\Model\Post', 'Brituy\SimpleBlog\Model\ResourceModel\Post');
    }

}
