<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\Message\Error;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Model\CategoriesFactory;

class Save extends Action
{
    protected $_coreRegistry;
    protected $_resultPageFactory;
    protected $_categoriesFactory;
 
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        CategoriesFactory $categoriesFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_categoriesFactory = $categoriesFactory;
 
    }
    
    /** @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity) */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        if ($data) 
        {
            $categoriesModel = $this->_categoriesFactory->create();
            $categoryid = $this->getRequest()->getParam('category_id');
            if ($categoryid){ $categoriesModel->load($categoryid); }
            $categoriesModel->setData($data);
            
            try {
            		$categoriesModel->save();
                	$this->messageManager->addSuccess(__('Category data was successfully saved.'));
                	
                	// Check if 'Save and Continue'
                	if ($this->getRequest()->getParam('back')) 
                	{
                    		$this->_redirect('*/*/edit', ['category_id' => $categoriesModel->getId(), '_current' => true]);
                    		return;
                	}
                	$this->_redirect('*/*/');
                	return;
                }
                catch (\Magento\Framework\Exception\LocalizedException $e) { $this->addSessionErrorMessages($e->getMessage()); }
                catch (\Exception $e) { $this->messageManager->addException($e, __('Something went wrong while saving category data.')); }
            
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['category_id' => $categoryid]);
        }
    }
}
