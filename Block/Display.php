<?php
// created a method getPostCollection to get all data on mageplaza_helloworld_post table and we will call it in template
namespace Brituy\SimpleBlog\Block;
class Display extends \Magento\Framework\View\Element\Template
{
	protected $_postFactory;
	
	public function __construct(\Magento\Framework\View\Element\Template\Context $context,
				     \Brituy\SimpleBlog\Model\PostFactory $postFactory)
	{
		$this->_postFactory = $postFactory;
		parent::__construct($context);
	}

	public function sayHello()
	{
		return __('Hello from display simple blog');
	}
	
	//get all data on brituy_sipleblog_main table and we will call it in template.
	public function getPostCollection()
	{
		$post = $this->_postFactory->create();
		return $post->getCollection();
	}
}
