<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Author;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\Message\Error;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Model\Authors;
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
            if ($authorid){ $authorsModel->load($authorid); }          		//category id is exist
                else { $author = $this->getRequest()->getParam('author');	//Get new author name
                	$dublicateCollection=$authorsModel->getAuthorByName($author);
                	if ($dublicateCollection)					//Check new author name
                	{
                	    $message = __("Author name: %1 already exist!",$author);
                	    $this->messageManager->addErrorMessage($message);
                	    $this->_redirect('*/*/edit', ['author'=>$author, '_current' => true]);
                	    return;
                	}
                	else { $mail = $this->getRequest()->getParam('author_mail');	//Get new author mail
                	       $dublicateCollection=$authorsModel->getAuthorByMail($mail);
                	       if ($dublicateCollection)
                	       {
                	           $message = __("E-Mail address: %1 already registred!",$mail);
                	           $this->messageManager->addErrorMessage($message);
                	           $this->_redirect('*/*/edit', ['author'=>$author, 'author_mail'=>$mail,'_current' => true]);
                	           return;
                	       }
                	     }
                     }
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
