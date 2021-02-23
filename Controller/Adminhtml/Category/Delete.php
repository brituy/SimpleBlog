<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\Error;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Model\CategoriesFactory;

class Delete extends Action
{
	/** Authorization level of a basic admin session
	 ** @see _isAllowed() */
	const ADMIN_RESOURCE = 'Brituy_SimpleBlog::category_delete';
	
	protected $_resultPageFactory;
	protected $_resultPage;
	protected $_categoriesFactory;
	
	public function __construct(Context $context, PageFactory $resultPageFactory, CategoriesFactory $categoriesFactory)
	{
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
		$this->_categoriesFactory = $categoriesFactory;
	}
	
	public function execute()
	{
		$categoryid = $this->getRequest()->getParam('category_id');
		if($categoryid>0)
		{
			$categoriesModel = $this->_categoriesFactory->create();
			$categoriesModel->load($categoryid);
			
			try {
				$categoriesModel->delete();
				
				$this->messageManager->addSuccess(__('Category data successfully deleted.'));
			} catch (\Exception $e) {
				$this->messageManager->addSuccess(__('Something went wrong while deleting the category data.'));
			}
		}
		$this->_redirect('*/*');
	}
}
