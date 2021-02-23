<?php
namespace Brituy\SimpleBlog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /** @var PageFactory */
    protected $resultPageFactory;

    /** Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory */
    public function __construct(Context $context,PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /** @return ResponseInterface|ResultInterface|Page */
    public function execute()
    {
        $resultPage=$this->resultPageFactory->create();
        
        $categoryid = $this->getRequest()->getParam('category_id');
        if ($categoryid)
        {
        	$resultPage->addHandle("blog_article_index_".$categoryid);
	}
	
        return $resultPage;
    }
}
