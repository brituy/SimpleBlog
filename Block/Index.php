<?php
namespace Brituy\SimpleBlog\Block;
class Index extends \Magento\Framework\View\Element\Template
{
//	protected $_postFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context
//		\Magento\Framework\View\Element\Template\Context $context,
//		\Brituy\SimpleBlog\Model\PostFactory $postFactory
	)
	{
//		$this->_postFactory = $postFactory;
		parent::__construct($context);
	}

	public function sayHello()
	{
		return __('Simple Blog block_sayHello');
	}

//	public function getPostCollection(){
//		$post = $this->_postFactory->create();
//		return $post->getCollection();
//	}
}
