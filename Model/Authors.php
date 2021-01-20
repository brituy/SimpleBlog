<?php
namespace Brituy\SimpleBlog\Model;

class Authors extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
	    $this->_init('Brituy\SimpleBlog\Model\ResourceModel\Authors');
    }
    
    public function getAuthorByName($author)
    {
        return $this->getCollection()->addFieldToFilter('author', $author)->getItems();
    }
    
    public function getAuthorByMail($mail)
    {
        return $this->getCollection()->addFieldToFilter('author_mail', $mail)->getItems();
    }
}
