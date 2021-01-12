<?php
namespace Brituy\SimpleBlog\Model\ResourceModel\Categories;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection 
{
    protected function _construct() 
    {
	$this->_init('Brituy\SimpleBlog\Model\Categories', 'Brituy\SimpleBlog\Model\ResourceModel\Categories');
    }
}
