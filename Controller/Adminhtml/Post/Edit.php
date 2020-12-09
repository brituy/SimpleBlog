<?php

namespace Brituy\SimpleBlog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Brituy\SimpleBlog\Controller\Adminhtml\Post;
use Brituy\SimpleBlog\Model\PostFactory;

/** Class Edit
 * @package Brituy\SimpleBlog\Controller\Adminhtml\Post */
class Edit extends Post
{
    /** Page factory
     * @var PageFactory */
    public $resultPageFactory;

    /** Edit constructor.
     * @param Context $context
     * @param Registry $registry
     * @param PostFactory $postFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PostFactory $postFactory,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($postFactory, $registry, $context);
    }

    /** @return \Magento\Backend\Model\View\Result\Page|Redirect|Page */
    public function execute()
    {
        /** @var \Brituy\SimpleBlog\Model\Post $post */
        $post = $this->initPost();
        $duplicate = $this->getRequest()->getParam('duplicate');

        if (!$post) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*');

            return $resultRedirect;
        }

        $data = $this->_session->getData('brituy_blog_main_data', true);
        if (!empty($data)) {
            $post->setData($data);
        }

        $this->coreRegistry->register('brituy_simpleblog_post', $post);

        /** @var \Magento\Backend\Model\View\Result\Page|Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Brituy_SimpleBlog::post');
        $resultPage->getConfig()->getTitle()->set(__('Articles'));

        $title = $post->getId() && !$duplicate ? $post->getName() : __('New Article');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
