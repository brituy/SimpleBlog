<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Author;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\Error;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Model\AuthorsFactory;

class Delete extends Action
{
	protected $_resultPageFactory;
	protected $_resultPage;
	protected $_authorsFactory;
	
	public function __construct(Context $context, PageFactory $resultPageFactory, AuthorsFactory $authorsFactory)
	{
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
		$this->_authorsFactory = $authorsFactory;
	}
	
	public function execute()
	{
		$authorid = $this->getRequest()->getParam('author_id');
		if($authorid>0)
		{
			$authorsModel = $this->_authorsFactory->create();
			$authorsModel->load($authorid);
			
			try {
				$authorsModel->delete();
				
				$this->messageManager->addSuccess(__('Authors data successfully deleted.'));
			} catch (\Exception $e) {
				$this->messageManager->addSuccess(__('Something went wrong while deleting the authors data.'));
			}
		}
		$this->_redirect('*/*');
	}
}
