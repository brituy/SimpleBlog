<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends \Magento\Backend\App\Action
{
    public $resultForwardFactory;
    
    public function __construct(Context $context,PageFactory $resultPageFactory,ForwardFactory $resultForwardFactory)
    {
        $this->resultForwardFactory = $resultForwardFactory;

        parent::__construct($context);
    }
    
    /** @return \Magento\Backend\Model\View\Result\Page */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
	$this->_forward('edit');
        return $resultForward;
    }
}
