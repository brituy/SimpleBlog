<?php

namespace Brituy\SimpleBlog\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Brituy\SimpleBlog\Model\PostFactory;

/** Class Post
 * @package Brituy\SimpleBlog\Controller\Adminhtml */
abstract class Post extends Action
{
    /** Post Factory
      * @var PostFactory */
    public $postFactory;

    /** Core registry
      * @var Registry */
    public $coreRegistry;

    /** Post constructor.
      * @param PostFactory $postFactory
      * @param Registry $coreRegistry
      * @param Context $context */
    public function __construct(
        PostFactory $postFactory,
        Registry $coreRegistry,
        Context $context
    ) {
        $this->postFactory = $postFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /** @param bool $register
      * @param bool $isSave
      * @return bool|\Brituy\SimpleBlog\Model\Post */
    protected function initPost($register = false, $isSave = false)
    {
        $postId = (int)$this->getRequest()->getParam('article_id');
        $duplicate = $this->getRequest()->getParam('post')['duplicate'] ?? null;

        /** @var \Brituy\SimpleBlog\Model\Post $post */
        $post = $this->postFactory->create();
        if ($postId) {
            if (!$isSave || !$duplicate) {
                $post->load($postId);
                if (!$post->getId()) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));

                    return false;
                }
            }
        }

        if ($register) {
            $this->coreRegistry->register('brituy_blog_main', $post);
        }

        return $post;
    }
}
