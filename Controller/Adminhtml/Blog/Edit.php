<?php
namespace Brituy\SimpleBlog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Brituy\SimpleBlog\Model\BlogFactory;

class Edit extends \Magento\Backend\App\Action
{
    private $coreRegistry;

    public $resultPageFactory;

    protected $resultForwardFactory;
    protected $_blogFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Registry $coreRegistry,
        BlogFactory $blogFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->_blogFactory = $blogFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $blogid = (int) $this->getRequest()->getParam('blog_id');
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($blogid) {
            $blogData = $this->_blogFactory->create()->load($blogid);

            if (!$blogData->getId()) {
                $this->messageManager->addError(__('Article no longer exist.'));
                $this->_redirect('*/*/*');
                return;
            }
        }else{ $blogData = $this->_blogFactory->create(); }

        $this->coreRegistry->register('simpleblog_article', $blogData);
        $resultPageFactory = $this->resultPageFactory->create();
        $resultPageFactory->getConfig()->getTitle()->prepend(
            $blogData->getId()
                ? __('Edit Article [%1]', $blogData->getId())
                : __('Create New Article')
        );
        return $resultPageFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Brituy_SimpleBlog::blog_save');
    }
}
