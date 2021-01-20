<?php
namespace Brituy\SimpleBlog\Model;

class Categories extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
	    $this->_init('Brituy\SimpleBlog\Model\ResourceModel\Categories');
    }
    
    public function getCategoryByName($category)
    {
        return $this->getCollection()->addFieldToFilter('category', $category)->getItems();
    }
}
