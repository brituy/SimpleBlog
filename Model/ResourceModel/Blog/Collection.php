<?php
namespace Brituy\SimpleBlog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection 
{
    protected function _construct() 
    {
	$this->_init('Brituy\SimpleBlog\Model\Blog', 'Brituy\SimpleBlog\Model\ResourceModel\Blog');
    }
}
