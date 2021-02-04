<?php
namespace Brituy\SimpleBlog\Model;

use Magento\Framework\Model\AbstractModel;

class Authors extends AbstractModel
{
    //protected function __construct(Context $context,Registry $registry,UrlInterface $urlBuilder,
    //					AbstractResource $resource = null,AbstractDb $resourceCollection = null,
	//				array $data = [])
    //{
	//    $this->_urlBuilder = $urlBuilder;
//    parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    //}
    
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
