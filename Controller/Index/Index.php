<?php
// execute() method, we will write all of our controller logic and will return response for the request
namespace Brituy\SimpleBlog\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_blogFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Brituy\SimpleBlog\Model\BlogFactory $blogFactory)
	{
		$this->_pageFactory = $pageFactory;
		$this->_blogFactory = $blogFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		$blog = $this->_blogFactory->create();
		$collection = $blog->getCollection();
		foreach($collection as $item){
			echo "<pre>";
			  print_r($item->getData());
			echo "</pre>";
		}
		exit();
		return $this->_pageFactory->create();
	}
}
