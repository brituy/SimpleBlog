<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\Message\Error;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Model\BlogFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;
    protected $_resultPageFactory;
    protected $_blogFactory;
 
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_blogFactory = $blogFactory;
 
    }
    
    /** @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity) */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        if ($data) 
        {
            $blogModel = $this->_blogFactory->create();
            $blogid = $this->getRequest()->getParam('blog_id');
            if ($blogid){ $blogModel->load($blogid); }
            $blogModel->setData($data);
            
            try {
            		$blogModel->save();
                	$this->messageManager->addSuccess(__('Article was successfully saved.'));
                	
                	// Check if 'Save and Continue'
                	if ($this->getRequest()->getParam('back')) 
                	{
                    		$this->_redirect('*/*/edit', ['blog_id' => $blogModel->getId(), '_current' => true]);
                    		return;
                	}
                	$this->_redirect('*/*/');
                	return;
                }
                catch (\Magento\Framework\Exception\LocalizedException $e) { $this->addSessionErrorMessages($e->getMessage()); }
                catch (\Exception $e) { $this->messageManager->addException($e, __('Something went wrong while saving the article.')); }
            
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['blog_id' => $blogid]);
        }
    }
}
