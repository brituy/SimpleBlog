<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\Error;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Model\BlogFactory;

class Delete extends Action
{
	protected $_resultPageFactory;
	protected $_resultPage;
	protected $_blogFactory;
	
	public function __construct(Context $context, PageFactory $resultPageFactory, BlogFactory $blogFactory)
	{
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
		$this->_blogFactory = $blogFactory;
	}
	
	public function execute()
	{
		$blogid = $this->getRequest()->getParam('blog_id');
		if($blogid>0)
		{
			$blogModel = $this->_blogFactory->create();
			$blogModel->load($blogid);
			
			try {
				$blogModel->delete();
				
				$this->messageManager->addSuccess(__('Article successfully deleted.'));
			} catch (\Exception $e) {
				$this->messageManager->addSuccess(__('Something went wrong while deleting the article.'));
			}
		}
		$this->_redirect('*/*');
	}
	
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Brituy_SimpleBlog::blog_delete');
	}
}
