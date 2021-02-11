<?php
namespace Brituy\SimpleBlog\Controller\Article;

use Brituy\SimpleBlog\Model\Config;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class View extends Action
{
    /** @var PageFactory */
    protected $resultPageFactory;

    protected $config;

    /** Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory */
    public function __construct(Context $context,PageFactory $resultPageFactory,Config $config)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->config = $config;
    }

    /** @return ResponseInterface|ResultInterface|Page */
    public function execute()
    {
        $blogid = $this->getRequest()->getParam('blog_id');
        if ($blogid)
        {
        	$resultPage=$this->resultPageFactory->create();
        	$resultPage->addHandle("blog_article_view_".$blogid);
		//$this->_redirect('blog/'.$blogid);
	}

        return $resultPage;
    }
}
