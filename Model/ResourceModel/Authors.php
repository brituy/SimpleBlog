<?php
namespace Brituy\SimpleBlog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Authors extends AbstractDb
{
    protected function _construct()
    {
    	// table name and id is Primary of Table
    	$this->_init('brituy_blog_authors', 'author_id');
    }
}
