<?php
namespace Brituy\SimpleBlog\Model\ResourceModel\Authors;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection 
{
    protected function _construct() 
    {
	$this->_init('Brituy\SimpleBlog\Model\Authors', 'Brituy\SimpleBlog\Model\ResourceModel\Authors');
    }
}
