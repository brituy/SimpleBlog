<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Author;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\Message\Error;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Model\AuthorsFactory;

class Save extends Action
{
    protected $_coreRegistry;
    protected $_resultPageFactory;
    protected $_authorsFactory;
 
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        AuthorsFactory $authorsFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_authorsFactory = $authorsFactory;
 
    }
    
    /** @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity) */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        if ($data) 
        {
            $authorsModel = $this->_authorsFactory->create();
            $authorid = $this->getRequest()->getParam('author_id');
            if ($authorid){ $authorsModel->load($authorid); }
            $authorsModel->setData($data);
            
            try {
            		$authorsModel->save();
                	$this->messageManager->addSuccess(__('Author data was successfully saved.'));
                	
                	// Check if 'Save and Continue'
                	if ($this->getRequest()->getParam('back')) 
                	{
                    		$this->_redirect('*/*/edit', ['author_id' => $authorsModel->getId(), '_current' => true]);
                    		return;
                	}
                	$this->_redirect('*/*/');
                	return;
                }
                catch (\Magento\Framework\Exception\LocalizedException $e) { $this->addSessionErrorMessages($e->getMessage()); }
                catch (\Exception $e) { $this->messageManager->addException($e, __('Something went wrong while saving author data.')); }
            
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['author_id' => $authorid]);
        }
    }
}
