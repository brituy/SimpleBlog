<?php

namespace Brituy\SimpleBlog\Block\Adminhtml\Post;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Brituy\SimpleBlog\Model\Post;

/** Class Edit
 * @package Brituy\SimpleBlog\Block\Adminhtml\Post */
class Edit extends Container
{
    /** Core registry @var Registry */
    public $coreRegistry;

    /** Edit constructor. */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context, $data);
    }

    /** Initialize Post edit block @return void */
    protected function _construct()
    {
        $this->_blockGroup = 'Brituy_SimpleBlog';
        $this->_controller = 'adminhtml_post';

        parent::_construct();

        if (!$this->getRequest()->getParam('history')) {
            $post = $this->coreRegistry->registry('brituy_simpleblog_post');

            $this->buttonList->remove('save');
            $this->buttonList->add(
                'save',
                [
                    'label' => __('Save'),
                    'class' => 'save primary',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'save', 'target' => '#edit_form']
                        ]
                    ],
                ],
                -100
            );

            $this->buttonList->add(
                'save-and-continue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']
                        ]
                    ]
                ],
                -100
            );
            if ($post->getId() && !$this->_request->getParam('duplicate')) {
                $this->buttonList->add(
                    'duplicate',
                    [
                        'label' => __('Duplicate'),
                        'class' => 'duplicate',
                        'onclick' => sprintf("location.href = '%s';", $this->getDuplicateUrl()),
                    ],
                    -101
                );
            } else {
                $this->buttonList->remove('delete');
            }
        }
    }

    /** Retrieve text for header element depending on loaded Post
     * @return string */
    public function getHeaderText()
    {
        /** @var Post $post */
        $post = $this->coreRegistry->registry('brituy_simpleblog_post');

        if ($post->getId() && $post->getDuplicate()) {
            return __("Edit Post '%1'", $this->escapeHtml($post->getName()));
        }

        return __('New Post');
    }

    /** Get form action URL
     * @return string */
    public function getFormActionUrl()
    {
        /** @var Post $post */
        $post = $this->coreRegistry->registry('brituy_simpleblog_post');
        if ($post->getId()) {
            if ($post->getDuplicate()) {
                $ar = [];
            } else {
                $ar = ['id' => $post->getId()];
            }
            if ($this->getRequest()->getParam('history')) {
                $ar['post_id'] = $this->getRequest()->getParam('post_id');
            }

            return $this->getUrl('*/*/save', $ar);
        }

        return parent::getFormActionUrl();
    }

    /** @return string */
    protected function getDuplicateUrl()
    {
        $post = $this->coreRegistry->registry('brituy_simpleblog_post');

        return $this->getUrl('*/*/duplicate', ['id' => $post->getId(), 'duplicate' => true]);
    }

    /** @return string */
    protected function getSaveDraftUrl()
    {
        return $this->getUrl('*/*/save', ['action' => 'draft']);
    }

    /** @return string */
    protected function getSaveAddHistoryUrl()
    {
        return $this->getUrl('*/*/save', ['action' => 'add']);
    }
}
